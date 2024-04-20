<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller\Api\V1;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Event\EventManagerInterface;
use Cake\Http\Response;
use Cake\View\JsonView;
use Exception;
use Authentication\Controller\Component\AuthenticationComponent;
use App\Services\Api\Response\ApiResponseHeaderServiceFactory;
use App\Services\Api\Response\ApiResponseHeaderServiceInterface;
use Authentication\Authenticator\ResultInterface;
use Authorization\Controller\Component\AuthorizationComponent;
use Authorization\Identity;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use App\Model\Entity\User;

/**
 * @property AuthenticationComponent $Authentication
 * @property AuthorizationComponent $Authorization
 */
class ApiAppController extends Controller
{
    protected readonly ApiResponseHeaderServiceInterface $apiResponseHeaderService;
    protected Identity $user;
    protected Log $logger;

    public function __construct(
        ServerRequest $request = null,
        ?string $name = null,
        ?EventManagerInterface $eventManager = null,
    ) {
        parent::__construct(
            $request,
            $name,
            $eventManager,
        );
        $this->apiResponseHeaderService = (new ApiResponseHeaderServiceFactory())();
        $this->logger = new Log();
    }

    /**
     * @throws Exception
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    /**
     * @deprecated
     * @param $data
     */
    public function output($data): Response
    {
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    public function viewClasses(): array
    {
        return [JsonView::class,];
    }

    /**
     * @return Response
     */
    public function beforeFilter(EventInterface $event): Response
    {
        $authenticationResult = $this->Authentication->getResult();

        /** @var Identity $user */
        $user = $this->Authentication->getIdentity();

        if (
            $authenticationResult->isValid()
            && $user[User::FIELD_STATUS] > User::STATUS_PENDING
        ) {
            // User is authenticated and has verified their account, continue
            $this->user = $user;
            return $this->response;
        }

        $this->Authorization->skipAuthorization();
        $this->logger->debug(
            sprintf(
                'Authentication Result: %s; Data: %s; Errors: %s;',
                $authenticationResult->getStatus(),
                $authenticationResult->getData(),
                json_encode($authenticationResult->getErrors()),
            )
        );

        switch ($authenticationResult->getStatus()) {
            case ResultInterface::FAILURE_CREDENTIALS_MISSING:
                $errors = [
                    'Provide authentication credentials',
                ];
            case ResultInterface::SUCCESS:
                if ($user[User::FIELD_STATUS] === User::STATUS_PENDING) {
                    $errors = [
                        'Please verify your account by email',
                    ];
                    break;
                }
            default:
                $errors = [
                    'Could not authenticate user',
                ];
        }

        if (env('DEBUG', false)) {
            $errors[] = $authenticationResult->getStatus();
            $errors[] = $authenticationResult->getErrors();
        }

        return $this->apiResponseHeaderService->returnUnauthorizedResponse(
            $this->response->withStringBody(json_encode([
                'errors' => $errors,
            ]))
        );
        // return $this->response->withType('application/json')
        //     ->withStringBody(json_encode($authenticationResult->getErrors(), JSON_OBJECT_AS_ARRAY));
    }

    /**
     * Determines whether the user is authorised to be able to use this action
     *
     * @return bool
     */
    public function isAuthorized($entity): void
    {
        $this->Authorization->authorize($entity);
    }

    // public function beforeRender(EventInterface $event)
    // {
    //     $exception = $event->getData('exception');

    //     if ($exception) {
    //         switch (true) {
    //             case ($exception instanceof NotFoundException):
    //                 break;
    //             default:
    //                 break;
    //         }
    //     }
    // }
}
