<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NonPlayableCharacters Controller
 *
 * @property \App\Model\Table\NonPlayableCharactersTable $NonPlayableCharacters
 *
 * @method \App\Model\Entity\NonPlayableCharacter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NonPlayableCharactersController extends AppController
{

    /**
     * Initialises the class, including authentication
     * 
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
        $this->Auth->allow();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tags']
        ];
        $nonPlayableCharacters = $this->paginate($this->NonPlayableCharacters);

        $this->set(compact('nonPlayableCharacters'));
    }

    /**
     * View method
     *
     * @param string|null $id Non Playable Character id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nonPlayableCharacter = $this->NonPlayableCharacters->get($id, [
            'contain' => ['Tags']
        ]);

        $this->set('nonPlayableCharacter', $nonPlayableCharacter);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nonPlayableCharacter = $this->NonPlayableCharacters->newEntity();
        if ($this->request->is('post')) {
            $nonPlayableCharacter = $this->NonPlayableCharacters->patchEntity($nonPlayableCharacter, $this->request->getData());
            if ($this->NonPlayableCharacters->save($nonPlayableCharacter)) {
                $this->Flash->success(__('The non playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The non playable character could not be saved. Please, try again.'));
        }
        $tags = $this->NonPlayableCharacters->Tags->find('list', ['limit' => 200]);
        $this->set(compact('nonPlayableCharacter', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Non Playable Character id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nonPlayableCharacter = $this->NonPlayableCharacters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nonPlayableCharacter = $this->NonPlayableCharacters->patchEntity($nonPlayableCharacter, $this->request->getData());
            if ($this->NonPlayableCharacters->save($nonPlayableCharacter)) {
                $this->Flash->success(__('The non playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The non playable character could not be saved. Please, try again.'));
        }
        $tags = $this->NonPlayableCharacters->Tags->find('list', ['limit' => 200]);
        $this->set(compact('nonPlayableCharacter', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Non Playable Character id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nonPlayableCharacter = $this->NonPlayableCharacters->get($id);
        if ($this->NonPlayableCharacters->delete($nonPlayableCharacter)) {
            $this->Flash->success(__('The non playable character has been deleted.'));
        } else {
            $this->Flash->error(__('The non playable character could not be deleted. Please, try again.'));
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
    // public function isAuthorized($user): bool
    // {
    //     $action = $this->request->getParam('action');
    //     // The add and tags actions are always allowed to logged in users
    //     if (in_array($action, [
    //         'add'
    //     ])) {
    //         return true;
    //     }

    //     // All other actions require an item ID
    //     $id = $this->request->getParam('id');

    //     if (!$id) {
    //         return false;
    //     }

    //     // Check that the nonPlayableCharacter belongs to the current user
    //     $nonPlayableCharacter = $this->NonPlayableCharacters->findById($id)->firstOrFail();

    //     return $nonPlayableCharacter->user_id === $user['id'];
    // }
}
