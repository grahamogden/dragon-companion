<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CharacterRaces Controller
 *
 * @property \App\Model\Table\CharacterRacesTable $CharacterRaces
 *
 * @method \App\Model\Entity\CharacterRace[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CharacterRacesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $characterRaces = $this->paginate($this->CharacterRaces);

        $this->set(compact('characterRaces'));
    }

    /**
     * View method
     *
     * @param string|null $id Character Race id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $characterRace = $this->CharacterRaces->get($id, contain: ['PlayerCharacters']);

        $this->set('characterRace', $characterRace);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $characterRace = $this->CharacterRaces->newEmptyEntity();
        if ($this->request->is('post')) {
            $characterRace = $this->CharacterRaces->patchEntity($characterRace, $this->request->getData());
            if ($this->CharacterRaces->save($characterRace)) {
                $this->Flash->success(__('The character race has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The character race could not be saved. Please, try again.'));
        }
        $playerCharacters = $this->CharacterRaces->PlayerCharacters->find('list', ['limit' => 200]);
        $this->set(compact('characterRace', 'playerCharacters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Character Race id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $characterRace = $this->CharacterRaces->get($id, contain: ['PlayerCharacters']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $characterRace = $this->CharacterRaces->patchEntity($characterRace, $this->request->getData());
            if ($this->CharacterRaces->save($characterRace)) {
                $this->Flash->success(__('The character race has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The character race could not be saved. Please, try again.'));
        }
        $playerCharacters = $this->CharacterRaces->PlayerCharacters->find('list', ['limit' => 200]);
        $this->set(compact('characterRace', 'playerCharacters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Character Race id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $characterRace = $this->CharacterRaces->get($id);
        if ($this->CharacterRaces->delete($characterRace)) {
            $this->Flash->success(__('The character race has been deleted.'));
        } else {
            $this->Flash->error(__('The character race could not be deleted. Please, try again.'));
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

        // Check that the characterRaces belongs to the current user
        $characterRaces = $this->CharacterRaces->findById($id)->firstOrFail();

        return $characterRaces->user_id === $user['id'];
    }
}
