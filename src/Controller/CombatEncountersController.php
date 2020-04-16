<?php

namespace App\Controller;

use App\Model\Entity\CombatEncounter;
use App\Model\Table\CombatEncountersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * CombatEncounters Controller
 *
 * @property CombatEncountersTable $CombatEncounters
 *
 * @method CombatEncounter[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class CombatEncountersController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];

        $user = $this->getUserOrRedirect();

        $combatEncounters = $this->CombatEncounters
            ->find()
            ->where(['user_id =' => $user['id']])
            ->order(['CombatEncounters.created DESC']);

        $combatEncountersPagination = $this->paginate($combatEncounters);

        $this->set('combatEncounters', $combatEncountersPagination);
    }

    /**
     * View method
     *
     * @param string|null $id Combat Encounter id.
     *
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $combatEncounter = $this->CombatEncounters->get(
            $id,
            [
                'contain' => [
                    'Users',
                    'Campaigns',
                    'Participants',
                ],
            ]
        );

        $this->set('combatEncounter', $combatEncounter);
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $combatEncounter = $this->CombatEncounters->newEntity();
        $user            = $this->getUserOrRedirect();

        if ($this->request->is('post')) {
            $data            = $this->request->getData();
            $data['user_id'] = $user['id'];
            debug($data);
            exit;
            $combatEncounter = $this->CombatEncounters->patchEntity($combatEncounter, $data);
            if ($this->CombatEncounters->save($combatEncounter)) {
                $this->Flash->success(__('The combat encounter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The combat encounter could not be saved. Please, try again.'));
        }

        $campaigns = $this->CombatEncounters->Campaigns
            ->find('list', ['limit' => 200])
            ->where(['user_id =' => $user['id']])
            ->order(['Campaigns.name ASC']);

        $this->loadModel('CombatActions');
        $combatActions = $this->CombatActions
            ->find('list', ['limit' => 200])
            ->order(['CombatActions.name ASC']);

        $this->set(
            compact(
                'combatEncounter',
                'campaigns',
                'combatActions'
            )
        );
    }

    /**
     * Edit method
     *
     * @param string|null $id Combat Encounter id.
     *
     * @return Response|void Redirects on successful edit, renders view otherwise.
     */
    public function edit(?string $id = null)
    {
        return $this->redirect(
            [
                'action' => 'view',
                $id,
            ]
        );
    }

    /**
     * Delete method
     *
     * @param string|null $id Combat Encounter id.
     *
     * @return Response|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(
            [
                'post',
                'delete',
            ]
        );
        $combatEncounter = $this->CombatEncounters->get($id);
        if ($this->CombatEncounters->delete($combatEncounter)) {
            $this->Flash->success(__('The combat encounter has been deleted.'));
        } else {
            $this->Flash->error(__('The combat encounter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Determines whether the user is authorised to be able to use this action
     *
     * @param array $user
     *
     * @return bool
     */
    public function isAuthorized($user): bool
    {
        $action = $this->request->getParam('action');
        // The add and index actions are always allowed to logged in users
        if (in_array(
            $action,
            [
                'add',
                'index',
            ]
        )) {
            return true;
        }

        // All other actions require an item ID
        $id = $this->request->getParam('id');

        if (!$id) {
            return false;
        }

        // Check that the combatEncounters belongs to the current user
        $combatEncounters = $this->CombatEncounters->findById($id)
            ->firstOrFail();

        return $combatEncounters->user_id
               === $user['id'];
    }
}
