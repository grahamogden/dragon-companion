<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CharacterRacesPlayableCharacters Controller
 *
 * @property \App\Model\Table\CharacterRacesPlayableCharactersTable $CharacterRacesPlayableCharacters
 *
 * @method \App\Model\Entity\CharacterRacesPlayableCharacter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CharacterRacesPlayableCharactersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CharacterRaces', 'PlayableCharacters']
        ];
        $characterRacesPlayableCharacters = $this->paginate($this->CharacterRacesPlayableCharacters);

        $this->set(compact('characterRacesPlayableCharacters'));
    }

    /**
     * View method
     *
     * @param string|null $id Character Races Playable Character id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $characterRacesPlayableCharacter = $this->CharacterRacesPlayableCharacters->get($id, [
            'contain' => ['CharacterRaces', 'PlayableCharacters']
        ]);

        $this->set('characterRacesPlayableCharacter', $characterRacesPlayableCharacter);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $characterRacesPlayableCharacter = $this->CharacterRacesPlayableCharacters->newEntity();
        if ($this->request->is('post')) {
            $characterRacesPlayableCharacter = $this->CharacterRacesPlayableCharacters->patchEntity($characterRacesPlayableCharacter, $this->request->getData());
            if ($this->CharacterRacesPlayableCharacters->save($characterRacesPlayableCharacter)) {
                $this->Flash->success(__('The character races playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The character races playable character could not be saved. Please, try again.'));
        }
        $characterRaces = $this->CharacterRacesPlayableCharacters->CharacterRaces->find('list', ['limit' => 200]);
        $playableCharacters = $this->CharacterRacesPlayableCharacters->PlayableCharacters->find('list', ['limit' => 200]);
        $this->set(compact('characterRacesPlayableCharacter', 'characterRaces', 'playableCharacters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Character Races Playable Character id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $characterRacesPlayableCharacter = $this->CharacterRacesPlayableCharacters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $characterRacesPlayableCharacter = $this->CharacterRacesPlayableCharacters->patchEntity($characterRacesPlayableCharacter, $this->request->getData());
            if ($this->CharacterRacesPlayableCharacters->save($characterRacesPlayableCharacter)) {
                $this->Flash->success(__('The character races playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The character races playable character could not be saved. Please, try again.'));
        }
        $characterRaces = $this->CharacterRacesPlayableCharacters->CharacterRaces->find('list', ['limit' => 200]);
        $playableCharacters = $this->CharacterRacesPlayableCharacters->PlayableCharacters->find('list', ['limit' => 200]);
        $this->set(compact('characterRacesPlayableCharacter', 'characterRaces', 'playableCharacters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Character Races Playable Character id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $characterRacesPlayableCharacter = $this->CharacterRacesPlayableCharacters->get($id);
        if ($this->CharacterRacesPlayableCharacters->delete($characterRacesPlayableCharacter)) {
            $this->Flash->success(__('The character races playable character has been deleted.'));
        } else {
            $this->Flash->error(__('The character races playable character could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
