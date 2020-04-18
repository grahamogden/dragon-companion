<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PlayerCharacters Controller
 *
 * @property \App\Model\Table\PlayerCharactersTable $PlayerCharacters
 *
 * @method \App\Model\Entity\PlayerCharacter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlayerCharactersController extends AppController
{
    public $paginate = [
        'limit' => 50,
        'order' => [
            'first_name' => 'asc'
        ],
        'sortWhitelist' => [
            'first_name',
            'last_name',
        ],
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Campaigns']
        ];

        $user = $this->getUserOrRedirect();

        $playerCharacters = $this->PlayerCharacters
            ->find()
            ->contain(['Campaigns'])
            ->where(['PlayerCharacters.user_id =' => $user['id']]);

        $playerCharactersPaginated = $this->paginate($playerCharacters);

        $this->set('playerCharacters', $playerCharactersPaginated);
    }

    /**
     * View method
     *
     * @param string|null $id Player Character id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $playerCharacter = $this->PlayerCharacters->get($id, [
            'contain' => ['Users', 'CharacterClasses', 'CharacterRaces', 'Participants'],
        ]);

        $this->set('playerCharacter', $playerCharacter);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $playerCharacter = $this->PlayerCharacters->newEntity();
        $user            = $this->getUserOrRedirect();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['user_id']    = $user['id'];
            $data['current_hp'] = $data['max_hp'];

            $playerCharacter  = $this->PlayerCharacters->patchEntity($playerCharacter, $data);

            if ($this->PlayerCharacters->save($playerCharacter)) {
                $this->Flash->success(__('The player character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The player character could not be saved. Please, try again.'));
        }

        $characterClasses = $this->PlayerCharacters->CharacterClasses
            ->find('list', ['limit' => 200])
            ->order(['name' => 'ASC']);
        $characterRaces = $this->PlayerCharacters->CharacterRaces
            ->find('list', ['limit' => 200])
            ->order(['name' => 'ASC']);
        $campaigns = $this->PlayerCharacters->Campaigns
            ->find('list', ['limit' => 200])
            ->where(['Campaigns.user_id =' => $user['id']])
            ->order(['name' => 'ASC']);

        $this->set(compact('playerCharacter', 'characterClasses', 'characterRaces', 'campaigns'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Player Character id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $playerCharacter = $this->PlayerCharacters->get($id, [
            'contain' => ['CharacterClasses', 'CharacterRaces']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $playerCharacter = $this->PlayerCharacters->patchEntity($playerCharacter, $this->request->getData());
            if ($this->PlayerCharacters->save($playerCharacter)) {
                $this->Flash->success(__('The player character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The player character could not be saved. Please, try again.'));
        }

        $characterClasses = $this->PlayerCharacters->CharacterClasses
            ->find('list', ['limit' => 200])
            ->order(['name' => 'ASC']);
        $characterRaces = $this->PlayerCharacters->CharacterRaces
            ->find('list', ['limit' => 200])
            ->order(['name' => 'ASC']);
        $campaigns = $this->PlayerCharacters->Campaigns
            ->find('list', ['limit' => 200])
            ->where(['Campaigns.user_id =' => $user['id']])
            ->order(['name' => 'ASC']);

        $this->set(compact('playerCharacter', 'characterClasses', 'characterRaces', 'campaigns'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Player Character id.
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $playerCharacter = $this->PlayerCharacters->get($id);
        
        if ($this->PlayerCharacters->delete($playerCharacter)) {
            $this->Flash->success(__('The player character has been deleted.'));
        } else {
            $this->Flash->error(__('The player character could not be deleted. Please, try again.'));
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

        // Check that the playerCharacters belongs to the current user
        $playerCharacters = $this->PlayerCharacters->findById($id)->firstOrFail();

        return $playerCharacters->user_id === $user['id'];
    }
}
