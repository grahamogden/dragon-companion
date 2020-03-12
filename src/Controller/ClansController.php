<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Clans Controller
 *
 * @property \App\Model\Table\ClansTable $Clans
 *
 * @method \App\Model\Entity\Clan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClansController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $clans = $this->paginate($this->Clans);
        $userId  = $this->Auth->user('id');

        $this->set(compact('clans', 'userId'));
    }

    /**
     * View method
     *
     * @param string|null $id Clan id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clan = $this->Clans->get($id, [
            'contain' => ['Users'],
        ]);

        $adminUsers = [];/*$clan->Users->find()->innerJoinWith('Clans', function($q) {//findById($adminUserId);
            return $q->where(['account_level =' => 10]);
        });*/

        $memberUsers = [];/*$clan->Users->find()->innerJoinWith('Clans', function($q) {//findById($adminUserId);
            return $q->where(['account_level !=' => 10]);
        });*/

        foreach($clan->users as $user) {
            if ($user->_joinData->account_level === 10) {
                $adminUsers[] = $user;
            } else {
                $memberUsers[] = $user;
            }
        }


// var_dump('<pre>',$adminUsers,'----------------------', $memberUsers,'<pre>');exit;
        $this->set(compact('clan', 'adminUsers', 'memberUsers'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clan = $this->Clans->newEntity();
        if ($this->request->is('post')) {
            $clan = $this->Clans->patchEntity($clan, $this->request->getData());
            $adminUser = $this->Clans->Users->newEntity();
            $this->Clans->Users->patchEntity($adminUser, ['user_id' => $this->Auth->user('id'), 'member_status' => 1, 'account_level' => 10]);
            if ($this->Clans->save($clan)) {
                $this->Flash->success(__('The clan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clan could not be saved. Please, try again.'));
        }
        $users = $this->Clans->Users->find('list', ['limit' => 200])->where(['id !=' => $this->Auth->user('id')]);

        $this->set(compact('clan', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Clan id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clan = $this->Clans->get($id, [
            'contain' => ['Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clan = $this->Clans->patchEntity($clan, $this->request->getData());
            if ($this->Clans->save($clan)) {
                $this->Flash->success(__('The clan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clan could not be saved. Please, try again.'));
        }
        $users = $this->Clans->Users->find('list', ['limit' => 200])->where(['id !=' => $this->Auth->user('id')]);

        $this->set(compact('clan', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Clan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clan = $this->Clans->get($id);
        if ($this->Clans->delete($clan)) {
            $this->Flash->success(__('The clan has been deleted.'));
        } else {
            $this->Flash->error(__('The clan could not be deleted. Please, try again.'));
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

        // Check that the clans belongs to the current user
        $clan = $this->Clans->findById($id)->contain('Users')->firstOrFail();
        $clanUserIds = array_column($clan->users, 'id');

        // var_dump('<pre>',,'</pre>');exit;

        return $clan->user_id === $user['id'] || in_array($user['id'], $clanUserIds);
    }
}
