<?php

namespace App\Controller;

use App\Model\Entity\NonPlayableCharacter;
use App\Model\Table\NonPlayableCharactersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\Network\Exception\NotFoundException;

/**
 * NonPlayableCharacters Controller
 *
 * @property NonPlayableCharactersTable $NonPlayableCharacters
 *
 * @method NonPlayableCharacter[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class NonPlayableCharactersController extends AppController
{
    public array $paginate = [
        'limit'         => 50,
        'order'         => [
            'NonPlayableCharacters.name' => 'asc',
        ],
        'sortableFields' => [
            'NonPlayableCharacters.name',
            'NonPlayableCharacters.age',
            'NonPlayableCharacters.occupation',
        ],
    ];

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $user = $this->getUserOrRedirect();

        $nonPlayableCharacters = $this->NonPlayableCharacters
            ->find()
            ->where(['NonPlayableCharacters.user_id =' => $user['id']]);

        $nonPlayableCharacters = $this->paginate($nonPlayableCharacters);

        $this->set(compact('nonPlayableCharacters'));
    }

    /**
     * View method
     *
     * @param string|null $id Non Playable Character id.
     *
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->getUserOrRedirect();

        $nonPlayableCharacter = $this->NonPlayableCharacters->get(
            $id,
            contain: [
                'TimelineSegments',
                'Alignments',
            ]
        );

        $this->set('nonPlayableCharacter', $nonPlayableCharacter);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nonPlayableCharacter = $this->NonPlayableCharacters->newEmptyEntity();
        $user                 = $this->getUserOrRedirect();

        if ($this->request->is('post')) {
            $data            = $this->request->getData();
            $data['user_id'] = $user['id'];

            $nonPlayableCharacter = $this->NonPlayableCharacters->patchEntity(
                $nonPlayableCharacter,
                $data
            );

            if ($this->NonPlayableCharacters->save($nonPlayableCharacter)) {
                $this->Flash->success(__('The non playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The non playable character could not be saved. Please, try again.'));
        }
        $timelineSegments = $this->NonPlayableCharacters->TimelineSegments->find('list', ['limit' => 200]);
        $alignments       = $this->NonPlayableCharacters->Alignments->find('list', ['limit' => 200]);

        $this->set(compact('nonPlayableCharacter', 'timelineSegments', 'alignments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Non Playable Character id.
     *
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nonPlayableCharacter = $this->NonPlayableCharacters->get(
            $id,
            contain: ['Alignments',]
        );

        if ($this->request->is(['patch', 'post', 'put'])) {
            $nonPlayableCharacter = $this->NonPlayableCharacters->patchEntity(
                $nonPlayableCharacter,
                $this->request->getData()
            );
            if ($this->NonPlayableCharacters->save($nonPlayableCharacter)) {
                $this->Flash->success(__('The non playable character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The non playable character could not be saved. Please, try again.'));
        }
        $timelineSegments = $this->NonPlayableCharacters->TimelineSegments->find('list', ['limit' => 200]);
        $alignments       = $this->NonPlayableCharacters->Alignments->find('list', ['limit' => 200]);

        $this->set(compact('nonPlayableCharacter', 'timelineSegments', 'alignments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Non Playable Character id.
     *
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
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
    public function isAuthorized($user): bool
    {
        $action = $this->request->getParam('action');
        // The add and index actions are always allowed to logged in users
        if (in_array(
            $action,
            [
                'add',
                'index',
            ]
        )) {
            return true;
        }

        // All other actions require an item ID
        $id = $this->request->getParam('id');

        if (!$id) {
            return false;
        }

        // Check that the nonPlayableCharacter belongs to the current user
        $nonPlayableCharacter = $this->NonPlayableCharacters->findById($id)->firstOrFail();

        return $nonPlayableCharacter->user_id === $user['id'];
    }
}
