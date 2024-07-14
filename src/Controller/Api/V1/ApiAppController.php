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

use App\Error\Api\ForbiddenError;
use App\Error\Api\UnauthorizedError;
use App\Model\Entity\User;
use App\Services\Api\Response\ApiResponseHeaderService;
use Authentication\Authenticator\ResultInterface;
use Authentication\Controller\Component\AuthenticationComponent;
use Authorization\Controller\Component\AuthorizationComponent;
use Authorization\Exception\ForbiddenException;
use Authorization\Identity;
use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Event\EventManagerInterface;
use Cake\Log\Log;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\View\JsonView;
use Exception;

/**
 * @property AuthenticationComponent $Authentication
 * @property AuthorizationComponent $Authorization
 */
class ApiAppController extends Controller
{
    protected Identity $user;
    protected Log $logger;

    public function __construct(
        protected readonly ApiResponseHeaderService $apiResponseHeaderService,
        ServerRequest $request = null,
        ?string $name = null,
        ?EventManagerInterface $eventManager = null,
    ) {
        parent::__construct(
            $request,
            $name,
            $eventManager,
        );
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
     * @param array $data
     */
    public function output(array $data): void
    {
        // return $this->response->withType('application/json')
        //     ->withStringBody(json_encode($data));

        $this->set($data);
        if (count($data) > 1) {
            $this->viewBuilder()->setOption('serialize', array_keys($data));
        } else {
            $this->viewBuilder()->setOption('serialize', array_keys($data)[0] ?? []);
        }
    }

    public function viewClasses(): array
    {
        return [JsonView::class,];
    }

    /**
     * @return Response
     */
    public function beforeFilter(EventInterface $event): ?Response
    {
        $response = parent::beforeFilter($event);
        $this->Authentication->beforeFilter();
        $authenticationResult = $this->Authentication->getResult();

        /** @var Identity $user */
        $user = $this->Authentication->getIdentity();

        if (
            $authenticationResult->isValid()
            && null !== $user
            && $user[User::FIELD_STATUS] > User::STATUS_PENDING
        ) {
            // User is authenticated and has verified their account, continue
            $this->user = $user;
            return $response;
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

        throw new UnauthorizedError(errors: $errors);
        // return $this->apiResponseHeaderService->returnUnauthorizedResponse(
        //     $this->response->withStringBody(json_encode([
        //         'errors' => $errors,
        //     ]))
        // );
        // return $this->response->withType('application/json')
        //     ->withStringBody(json_encode($authenticationResult->getErrors(), JSON_OBJECT_AS_ARRAY));
    }

    /**
     * Determines whether the user is authorised to be able to use this action
     */
    public function isAuthorized(EntityInterface $entity): void
    {
        try {
            $this->Authorization->authorize($entity);
        } catch (ForbiddenException $exception) {
            $this->log($exception->getMessage());
            throw new ForbiddenError();
        }
    }

    /**
     * Checks whether the user is authorized but returns a boolean rather
     * than throw an exception - this should be used for lists of entities
     * to know whether the user is allowed to see that item in the list
     */
    private function isAuthorizedCheck(EntityInterface $entity): bool
    {
        try {
            $this->Authorization->authorize(resource: $entity);
            return true;
        } catch (ForbiddenException $exception) {
            return false;
        }
    }

    /**
     * @deprecated This is no longer how we authorize multipe entities, instead
     * it should be done through the database to be more consistent with
     * results for pagination, etc.
     * 
     * Accepts an array of entities and returns any/all of the entities that
     * the user is authorized to perform the action on or skips authorization
     * entirely if there are no entities to check
     *
     * @param array $entities
     * @return array
     */
    public function getAuthorizedEntities(array $entities): array
    {
        if (count($entities) === 0) {
            // If there are no timelines, then we can't authorize for anything
            $this->Authorization->skipAuthorization();

            return [];
        }

        $authorizedEntities = [];

        foreach ($entities as $entity) {
            if ($this->isAuthorizedCheck(entity: $entity)) {
                $authorizedEntities[] = $entity;
            }
        }

        return $authorizedEntities;
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
