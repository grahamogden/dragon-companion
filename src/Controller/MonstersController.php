<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Monsters Controller
 *
 * @property \App\Model\Table\MonstersTable $Monsters
 *
 * @method \App\Model\Entity\Monster[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MonstersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $monsters = $this->paginate($this->Monsters);

        $this->set(compact('monsters'));
    }

    /**
     * View method
     *
     * @param string|null $id Monster id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $monster = $this->Monsters->get($id, [
            'contain' => ['MonsterInstances']
        ]);

        $this->set('monster', $monster);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $monster = $this->Monsters->newEntity();
        if ($this->request->is('post')) {
            $monster = $this->Monsters->patchEntity($monster, $this->request->getData());
            if ($this->Monsters->save($monster)) {
                $this->Flash->success(__('The monster has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The monster could not be saved. Please, try again.'));
        }
        $this->set(compact('monster'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Monster id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $monster = $this->Monsters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $monster = $this->Monsters->patchEntity($monster, $this->request->getData());
            if ($this->Monsters->save($monster)) {
                $this->Flash->success(__('The monster has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The monster could not be saved. Please, try again.'));
        }
        $this->set(compact('monster'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Monster id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $monster = $this->Monsters->get($id);
        if ($this->Monsters->delete($monster)) {
            $this->Flash->success(__('The monster has been deleted.'));
        } else {
            $this->Flash->error(__('The monster could not be deleted. Please, try again.'));
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

        // Check that the monsters belongs to the current user
        $monsters = $this->Monsters->findById($id)->firstOrFail();

        return $monsters->user_id === $user['id'];
    }
}
