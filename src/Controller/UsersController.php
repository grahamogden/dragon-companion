<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Log\Log;
use Exception;

/**
 * Users Controller
 *
 * @property UsersTable $Users
 *
 * @method User[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        // $this->Auth->allow(['logout', 'add']);
        $this->Authentication->allowUnauthenticated(['logout', 'add']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        try {
            if ($this->request->is('post')) {
                $data = $this->request->getData();
                $data['status'] = User::STATUS_ACTIVE;
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));

                    return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                }
                // Log::Debug(var_dump($user->getErrors()));
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'register']);
            }
            // $this->set(compact('user'));
        } catch (Exception $e) {
            $this->Flash->error(__('The user could not be saved. Username already used. Please, try again.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     */
    public function edit(?string $id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     *
     * @throws RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param EventInterface $event
     *
     * @return Response|void|null
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['login']);
    }

    /**
     * @return Response|void|null
     */
    public function login()
    {
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';

            return $this->redirect($target);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }

        // if ($this->request->is('post')) {
        //     $user = $this->Auth->identify();
        //     if ($user) {
        //         $this->Auth->setUser($user);
        //         return $this->redirect($this->Auth->redirectUrl());
        //     }
        //     $this->Flash->error('Your username or password is incorrect.');
        // }
    }

    /**
     * @return Response|null
     */
    public function logout()
    {
        $this->Authentication->logout();
        $this->Flash->success('You are now logged out.');
        $this->request->getSession()->destroy();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

}
