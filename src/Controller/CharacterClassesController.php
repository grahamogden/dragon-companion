<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CharacterClasses Controller
 *
 * @property \App\Model\Table\CharacterClassesTable $CharacterClasses
 *
 * @method \App\Model\Entity\CharacterClass[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CharacterClassesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $characterClasses = $this->paginate($this->CharacterClasses);

        $this->set(compact('characterClasses'));
    }

    /**
     * View method
     *
     * @param string|null $id Character Class id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $characterClass = $this->CharacterClasses->get($id, [
            'contain' => ['PlayerCharacters']
        ]);

        $this->set('characterClass', $characterClass);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $characterClass = $this->CharacterClasses->newEmptyEntity();
        if ($this->request->is('post')) {
            $characterClass = $this->CharacterClasses->patchEntity($characterClass, $this->request->getData());
            if ($this->CharacterClasses->save($characterClass)) {
                $this->Flash->success(__('The character class has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The character class could not be saved. Please, try again.'));
        }
        $playerCharacters = $this->CharacterClasses->PlayerCharacters->find('list', ['limit' => 200]);
        $this->set(compact('characterClass', 'playerCharacters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Character Class id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $characterClass = $this->CharacterClasses->get($id, [
            'contain' => ['PlayerCharacters']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $characterClass = $this->CharacterClasses->patchEntity($characterClass, $this->request->getData());
            if ($this->CharacterClasses->save($characterClass)) {
                $this->Flash->success(__('The character class has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The character class could not be saved. Please, try again.'));
        }
        $playerCharacters = $this->CharacterClasses->PlayerCharacters->find('list', ['limit' => 200]);
        $this->set(compact('characterClass', 'playerCharacters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Character Class id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $characterClass = $this->CharacterClasses->get($id);
        if ($this->CharacterClasses->delete($characterClass)) {
            $this->Flash->success(__('The character class has been deleted.'));
        } else {
            $this->Flash->error(__('The character class could not be deleted. Please, try again.'));
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

        // Check that the characterClasses belongs to the current user
        $characterClasses = $this->CharacterClasses->findById($id)->firstOrFail();

        return $characterClasses->user_id === $user['id'];
    }
}
