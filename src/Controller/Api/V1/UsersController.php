<?php
namespace App\Controller\Api\V1;

use App\Application;
use App\Controller\AppController\Api\V1;
use App\Model\Entity\CombatEncounter;
use App\Model\Table\UsersTable;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

/**
 * Users Controller
 *
 * @property UsersTable $Users
 *
 * @method CombatEncounter[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends ApiAppController
{

    /**
     * Looks up tags based on a wildcard search term,
     * starting with at least three character
     *
     * @return string
     */
    public function getUsers(): void
    {
        $this->autoRender = false;
        $term             = $this->request->getQuery('term');
        $conditions       = json_decode($this->request->getQuery('conditions'), true);

        if ($this->request->is('ajax') && strlen($term) >= 3) {
            $campaign = $this->request->getSession()->read(Application::SESSION_KEY_CAMPAIGN);

            if (!isset($campaign) || !$campaign['id']) {
                header('HTTP/1.0 400 Bad request');
                $this->output(['label' => 'Please submit a campaign ID']);
            }

            $this->loadModel('Users');

            $whereConditions = [
                'Users.username LIKE' => $term . '%',
            ];

            if ($conditions['excludes']) {
                $whereConditions['Users.id NOT IN'] = $conditions['excludes'];
            }

            $results = $this->Users->find()
                ->notMatching(
                    'Campaigns',
                    function (Query $q) use ($campaign) {
                        return $q->where(['Campaigns.id =' => $campaign['id']]);
                    }
                )
                ->where($whereConditions)
                ->limit(20);

            if ($results->count()) {
                foreach ($results as $result) {
                    $return[] = [
                        'label' => $result->username,
                        'value' => $result->id,
                    ];
                }
            } else {
                $return[] = [
                    'label' => 'No results found',
                    'value' => 'No results found',
                ];
            }
        } else {
            $return[] = [
                'label' => 'No results found',
                'value' => 'No results found',
            ];
        }

        $this->output($return);
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        exit('index');
        $combatEncounters = $this->Users->find('all');
        $this->set([
            'Users' => $combatEncounters,
            '_serialize' => [
                'Users'
            ]
        ]);
    }

    public function view()
    {
        exit('view');
        $combatEncounter = $this->Users->findById($this->request->getParam('id'));
        $this->set([
            'Users' => $combatEncounter,
            '_serialize' => [
                'Users'
            ]
        ]);
    }

    /**
     * Determines whether the user is authorised to be able to use this action
     * 
     * @param type $user
     * 
     * @return bool
     */
    public function isAuthorized($user): bool
    {
        $action = $this->request->getParam('action');
        // The add and index actions are always allowed to logged in users
        if (in_array($action, [
            'add',
            'index',
        ])) {
            return true;
        }

        // All other actions require an item ID
        $id = $this->request->getParam('id');

        if (!$id) {
            return false;
        }

        // Check that the combatEncounters belongs to the current user
        $combatEncounters = $this->Users->findById($id)->firstOrFail();

        return $combatEncounters->user_id === $user['id'];
    }
}
