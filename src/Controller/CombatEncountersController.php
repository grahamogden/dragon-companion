<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CombatEncounters Controller
 *
 * @property \App\Model\Table\CombatEncountersTable $CombatEncounters
 *
 * @method \App\Model\Entity\CombatEncounter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CombatEncountersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
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
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $combatEncounter = $this->CombatEncounters->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('combatEncounter', $combatEncounter);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $combatEncounter = $this->CombatEncounters->newEntity();
        if ($this->request->is('post')) {
            $combatEncounter = $this->CombatEncounters->patchEntity($combatEncounter, $this->request->getData());
            if ($this->CombatEncounters->save($combatEncounter)) {
                $this->Flash->success(__('The combat encounter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The combat encounter could not be saved. Please, try again.'));
        }
        $users = $this->CombatEncounters->Users->find('list', ['limit' => 200]);
        $this->set(compact('combatEncounter', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Combat Encounter id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $combatEncounter = $this->CombatEncounters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $combatEncounter = $this->CombatEncounters->patchEntity($combatEncounter, $this->request->getData());
            if ($this->CombatEncounters->save($combatEncounter)) {
                $this->Flash->success(__('The combat encounter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The combat encounter could not be saved. Please, try again.'));
        }
        $users = $this->CombatEncounters->Users->find('list', ['limit' => 200]);
        $this->set(compact('combatEncounter', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Combat Encounter id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
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
        $combatEncounters = $this->CombatEncounters->findById($id)->firstOrFail();

        return $combatEncounters->user_id === $user['id'];
    }
}
