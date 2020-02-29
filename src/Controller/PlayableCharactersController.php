<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PlayableCharacters Controller
 *
 * @property \App\Model\Table\PlayableCharactersTable $PlayableCharacters
 *
 * @method \App\Model\Entity\PlayableCharacter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlayableCharactersController extends AppController
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
        $playableCharacters = $this->paginate($this->PlayableCharacters);

        $this->set(compact('playableCharacters'));
    }

    /**
     * View method
     *
     * @param string|null $id Playable Character id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $playableCharacter = $this->PlayableCharacters->get($id, [
            'contain' => ['Users', 'CharacterClasses', 'CharacterRaces', 'Participants']
        ]);

        $this->set('playableCharacter', $playableCharacter);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $playableCharacter = $this->PlayableCharacters->newEntity();
        if ($this->request->is('post')) {
            $playableCharacter = $this->PlayableCharacters->patchEntity($playableCharacter, $this->request->getData());
            if ($this->PlayableCharacters->save($playableCharacter)) {
                $this->Flash->success(__('The playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The playable character could not be saved. Please, try again.'));
        }
        $users = $this->PlayableCharacters->Users->find('list', ['limit' => 200]);
        $characterClasses = $this->PlayableCharacters->CharacterClasses->find('list', ['limit' => 200]);
        $characterRaces = $this->PlayableCharacters->CharacterRaces->find('list', ['limit' => 200]);
        $this->set(compact('playableCharacter', 'users', 'characterClasses', 'characterRaces'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Playable Character id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $playableCharacter = $this->PlayableCharacters->get($id, [
            'contain' => ['CharacterClasses', 'CharacterRaces']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $playableCharacter = $this->PlayableCharacters->patchEntity($playableCharacter, $this->request->getData());
            if ($this->PlayableCharacters->save($playableCharacter)) {
                $this->Flash->success(__('The playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The playable character could not be saved. Please, try again.'));
        }
        $users = $this->PlayableCharacters->Users->find('list', ['limit' => 200]);
        $characterClasses = $this->PlayableCharacters->CharacterClasses->find('list', ['limit' => 200]);
        $characterRaces = $this->PlayableCharacters->CharacterRaces->find('list', ['limit' => 200]);
        $this->set(compact('playableCharacter', 'users', 'characterClasses', 'characterRaces'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Playable Character id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $playableCharacter = $this->PlayableCharacters->get($id);
        if ($this->PlayableCharacters->delete($playableCharacter)) {
            $this->Flash->success(__('The playable character has been deleted.'));
        } else {
            $this->Flash->error(__('The playable character could not be deleted. Please, try again.'));
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

        // Check that the playableCharacters belongs to the current user
        $playableCharacters = $this->PlayableCharacters->findById($id)->firstOrFail();

        return $playableCharacters->user_id === $user['id'];
    }
}
