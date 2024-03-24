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

namespace App\Controller;

use App\Application;
use App\Model\Entity\Campaign;
use App\Model\Entity\User;
use Authentication\Controller\Component\AuthenticationComponent;
use Authentication\IdentityInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Exception;

use RuntimeException;

use function mysql_xdevapi\getSession;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 * @property AuthenticationComponent $Authentication
 * @property AuthorizationComponent $Authorization
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     * @throws Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        // $this->loadComponent('Csrf');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        $this->loadComponent('Flash');

        // $this->loadComponent('Auth', [
        //     'authorize'=> 'Controller',
        //     'authenticate' => [
        //         'Form' => [
        //             'fields' => [
        //                 'username' => 'username',
        //                 'password' => 'password'
        //             ],
        //         ],
        //     ],
        //     'loginAction' => [
        //         'controller' => 'Users',
        //         'action' => 'login'
        //     ],
        //      // If unauthorized, return them to page they were just on
        //     'unauthorizedRedirect' => $this->referer()
        // ]);
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');

        // Allow the display action so our PagesController
        // continues to work. Also enable the read only actions.
        // $this->Auth->allow(['display']);
        $this->Authentication->allowUnauthenticated(['display', 'view']);
        $this->Authorization->skipAuthorization();
    }

    /**
     * Retrieves the excluding IDs from the request object, removing blanks and
     * non-numeric IDs in the process
     *
     * @return array
     */
    protected function getExcludesFromRequest(): array
    {
        $excludes = $this->request->getQuery('excludes')
            ? explode(',', $this->request->getQuery('excludes'))
            : [];

        array_walk(
            $excludes,
            static function (&$value) {
                $value = trim($value);
                $value = is_numeric($value) ? (int) $value : null;
            }
        );

        return array_unique(array_filter($excludes));
    }

    /**
     * Generates a json encoded string using the results
     *
     * @param Table      $entity - the entity that is going to be searched
     * @param string     $term - the search term (used to prevent searches of less than 3 characters)
     * @param array      $conditions - the conditions that are going to be used
     * @param string     $displayFieldName - the DB field name that is going to be shown to the user
     * @param string     $valueFieldName - the DB field name that is going to be used to used
     * @param array|null $additionalReturnData - list of fields to return in the 'data' property
     *
     * @return string
     */
    protected function formatJsonResponse(
        Table $entity,
        string $term,
        array $conditions,
        string $displayFieldName,
        string $valueFieldName,
        ?array $additionalReturnData
    ): string {
        $returnArray = [];

        if ($this->request->is('ajax') && strlen($term) >= 3) {
            $results = $entity->find('all', conditions: $conditions);

            foreach ($results as $result) {
                $return = [
                    'label'        => $result->$displayFieldName,
                    'value'        => $result->$valueFieldName,
                ];

                if (!empty($additionalReturnData)) {
                    foreach ($additionalReturnData as $additionalReturnDataName) {
                        $return['data'][$additionalReturnDataName] = $result->$additionalReturnDataName;
                    }
                }

                $returnArray[] = $return;
            }
        }

        if (empty($returnArray)) {
            $returnArray[] = [
                'label'        => 'No results found',
                'value'        => '',
            ];
        }

        return json_encode($returnArray);
    }

    /**
     * Retrieves the User array from Auth or redirects the user
     * @return IdentityInterface
     */
    protected function getUserOrRedirect(): IdentityInterface
    {
        $user = $this->Authentication->getIdentity();//user();

        if (null === $user || empty($user)) {
            $this->redirect($this->Authentication->logout());
        }

        return $user;
    }

    /**
     * Retrieves the Campaign ID from the session or throws an exception
     *
     * @throws RuntimeException
     */
    protected function getCampaignIdOrRedirect(): int|Response
    {
        $user = $this->getUserOrRedirect();

        /** @var Campaign $campaign */
        $campaign = $this->getRequest()->getSession()->read(Application::SESSION_KEY_CAMPAIGN);

        if (empty($campaign) || null === $campaign) {
            $this->Flash->error('Please select a campaign');
            return $this->redirect(['controller' => 'Campaigns', 'action' => 'index']);
        }

        return $campaign->id;
    }

    public function isAuthorized($user): bool
    {
        // By default deny access.
        return false;
    }
}
