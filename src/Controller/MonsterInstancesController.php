<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MonsterInstances Controller
 *
 * @property \App\Model\Table\MonsterInstancesTable $MonsterInstances
 *
 * @method \App\Model\Entity\MonsterInstance[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MonsterInstancesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Monsters']
        ];
        $monsterInstances = $this->paginate($this->MonsterInstances);

        $this->set(compact('monsterInstances'));
    }

    /**
     * View method
     *
     * @param string|null $id Monster Instance id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $monsterInstance = $this->MonsterInstances->get($id, [
            'contain' => ['Monsters', 'Participants']
        ]);

        $this->set('monsterInstance', $monsterInstance);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $monsterInstance = $this->MonsterInstances->newEntity();
        if ($this->request->is('post')) {
            $monsterInstance = $this->MonsterInstances->patchEntity($monsterInstance, $this->request->getData());
            if ($this->MonsterInstances->save($monsterInstance)) {
                $this->Flash->success(__('The monster instance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The monster instance could not be saved. Please, try again.'));
        }
        $monsters = $this->MonsterInstances->Monsters->find('list', ['limit' => 200]);
        $this->set(compact('monsterInstance', 'monsters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Monster Instance id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $monsterInstance = $this->MonsterInstances->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $monsterInstance = $this->MonsterInstances->patchEntity($monsterInstance, $this->request->getData());
            if ($this->MonsterInstances->save($monsterInstance)) {
                $this->Flash->success(__('The monster instance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The monster instance could not be saved. Please, try again.'));
        }
        $monsters = $this->MonsterInstances->Monsters->find('list', ['limit' => 200]);
        $this->set(compact('monsterInstance', 'monsters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Monster Instance id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $monsterInstance = $this->MonsterInstances->get($id);
        if ($this->MonsterInstances->delete($monsterInstance)) {
            $this->Flash->success(__('The monster instance has been deleted.'));
        } else {
            $this->Flash->error(__('The monster instance could not be deleted. Please, try again.'));
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

        // Check that the monsterInstances belongs to the current user
        $monsterInstances = $this->MonsterInstances->findById($id)->firstOrFail();

        return $monsterInstances->user_id === $user['id'];
    }
}
