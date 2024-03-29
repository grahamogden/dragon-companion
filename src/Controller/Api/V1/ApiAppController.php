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
use Authorization\Controller\Component\AuthorizationComponent;
use Authorization\Identity;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\ServerRequest;

/**
 * @property AuthenticationComponent $Authentication
 * @property AuthorizationComponent $Authorization
 */
class ApiAppController extends Controller
{
    protected readonly ApiResponseHeaderServiceInterface $apiResponseHeaderService;
    protected Identity $user;

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

    public function beforeFilter(EventInterface $event)
    {
        $authenticationResult = $this->Authentication->getResult();
        if (!$authenticationResult->isValid()) {
            $this->Authorization->skipAuthorization();
            $this->apiResponseHeaderService->returnUnauthorizedResponse($this->response);
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($authenticationResult->getErrors(), JSON_OBJECT_AS_ARRAY));
        }
        $this->user = $this->Authentication->getIdentity();
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
