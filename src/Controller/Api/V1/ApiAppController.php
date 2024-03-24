<?php

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
use Cake\Http\Response;
use Cake\View\JsonView;
use Exception;
use Authentication\Controller\Component\AuthenticationComponent;
use App\Services\Api\Response\ApiResponseHeaderServiceFactory;
use App\Services\Api\Response\ApiResponseHeaderServiceInterface;
use Authorization\Controller\Component\AuthorizationComponent;
use Authorization\Identity;
use Cake\Http\Exception\NotFoundException;

/**
 * @property AuthenticationComponent $Authentication
 * @property AuthorizationComponent $Authorization
 */
class ApiAppController extends Controller
{
    protected readonly ApiResponseHeaderServiceInterface $apiResponseHeaderService;
    protected Identity $user;

    public function __construct(
        $request = null,
        $response = null,
        $name = null,
        $eventManager = null,
        $components = null,
    ) {
        parent::__construct(
            $request,
            $response,
            $name,
            $eventManager,
            $components
        );
        $this->apiResponseHeaderService = (new ApiResponseHeaderServiceFactory())();
        // $this->Users = $this->fetchTable('Users');
    }

    /**
     * @throws Exception
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    /**
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
            return $this->getResponse()->withType('application/json')
                ->withStringBody(json_encode($authenticationResult->getErrors(), JSON_OBJECT_AS_ARRAY))
                ->withStatus(401);
            // $this->apiResponseHeaderService->returnUnauthorizedResponse();
        }
        $this->user = $this->Authentication->getIdentity();
    }

    public function beforeRender(EventInterface $event)
    {
        $exception = $event->getData('exception');

        if ($exception) {
            switch (true) {
                case ($exception instanceof NotFoundException):
                    break;
                default:
                    break;
            }
        }
    }
}
