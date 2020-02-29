<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CharacterClassesPlayableCharacters Controller
 *
 * @property \App\Model\Table\CharacterClassesPlayableCharactersTable $CharacterClassesPlayableCharacters
 *
 * @method \App\Model\Entity\CharacterClassesPlayableCharacter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CharacterClassesPlayableCharactersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CharacterClasses', 'PlayableCharacters']
        ];
        $characterClassesPlayableCharacters = $this->paginate($this->CharacterClassesPlayableCharacters);

        $this->set(compact('characterClassesPlayableCharacters'));
    }

    /**
     * View method
     *
     * @param string|null $id Character Classes Playable Character id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $characterClassesPlayableCharacter = $this->CharacterClassesPlayableCharacters->get($id, [
            'contain' => ['CharacterClasses', 'PlayableCharacters']
        ]);

        $this->set('characterClassesPlayableCharacter', $characterClassesPlayableCharacter);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $characterClassesPlayableCharacter = $this->CharacterClassesPlayableCharacters->newEntity();
        if ($this->request->is('post')) {
            $characterClassesPlayableCharacter = $this->CharacterClassesPlayableCharacters->patchEntity($characterClassesPlayableCharacter, $this->request->getData());
            if ($this->CharacterClassesPlayableCharacters->save($characterClassesPlayableCharacter)) {
                $this->Flash->success(__('The character classes playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The character classes playable character could not be saved. Please, try again.'));
        }
        $characterClasses = $this->CharacterClassesPlayableCharacters->CharacterClasses->find('list', ['limit' => 200]);
        $playableCharacters = $this->CharacterClassesPlayableCharacters->PlayableCharacters->find('list', ['limit' => 200]);
        $this->set(compact('characterClassesPlayableCharacter', 'characterClasses', 'playableCharacters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Character Classes Playable Character id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $characterClassesPlayableCharacter = $this->CharacterClassesPlayableCharacters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $characterClassesPlayableCharacter = $this->CharacterClassesPlayableCharacters->patchEntity($characterClassesPlayableCharacter, $this->request->getData());
            if ($this->CharacterClassesPlayableCharacters->save($characterClassesPlayableCharacter)) {
                $this->Flash->success(__('The character classes playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The character classes playable character could not be saved. Please, try again.'));
        }
        $characterClasses = $this->CharacterClassesPlayableCharacters->CharacterClasses->find('list', ['limit' => 200]);
        $playableCharacters = $this->CharacterClassesPlayableCharacters->PlayableCharacters->find('list', ['limit' => 200]);
        $this->set(compact('characterClassesPlayableCharacter', 'characterClasses', 'playableCharacters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Character Classes Playable Character id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $characterClassesPlayableCharacter = $this->CharacterClassesPlayableCharacters->get($id);
        if ($this->CharacterClassesPlayableCharacters->delete($characterClassesPlayableCharacter)) {
            $this->Flash->success(__('The character classes playable character has been deleted.'));
        } else {
            $this->Flash->error(__('The character classes playable character could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
