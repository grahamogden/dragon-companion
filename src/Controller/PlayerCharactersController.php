<?php

namespace App\Controller;

use App\Model\Entity\PlayerCharacter;
use App\Model\Table\PlayerCharactersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

/**
 * PlayerCharacters Controller
 *
 * @method PlayerCharacter[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlayerCharactersController extends AppController
{
    public $paginate = [
        'limit'         => 50,
        'order'         => [
            'first_name' => 'asc',
        ],
        'sortWhitelist' => [
            'first_name',
            'last_name',
        ],
    ];

    /** @var PlayerCharactersTable|null */
    private $playerCharactersTable;

    public function initialize(): void
    {
        parent::initialize();

        $this->playerCharactersTable = $this->fetchTable('PlayerCharacters');
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Campaigns'],
        ];

        $user = $this->getUserOrRedirect();

        $playerCharacters = $this->playerCharactersTable
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
     *
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $playerCharacter = $this->playerCharactersTable->get(
            $id,
            [
                'contain' => [
                    'Alignments',
                    'Campaigns',
                    'Users',
                    'CharacterClasses',
                    'CharacterRaces',
                    'Participants',
                ],
            ]
        );

        $this->set('playerCharacter', $playerCharacter);
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $playerCharacter = $this->playerCharactersTable->newEmptyEntity();
        $user            = $this->getUserOrRedirect();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['user_id']    = $user['id'];

            $playerCharacter = $this->playerCharactersTable->patchEntity($playerCharacter, $data);

            if ($this->playerCharactersTable->save($playerCharacter)) {
                $this->Flash->success(__('The player character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The player character could not be saved. Please, try again.'));
        }

        $this->loadModel('Campaigns');

        $characterClasses = $this->playerCharactersTable->CharacterClasses
            ->find('list', ['limit' => 200])
            ->order(['name' => 'ASC']);
        $characterRaces   = $this->playerCharactersTable->CharacterRaces
            ->find('list', ['limit' => 200])
            ->order(['name' => 'ASC']);
        $alignments       = $this->playerCharactersTable->Alignments
            ->find('list', ['limit' => 200]);
        $campaigns        = $this->Campaigns->find('list')
            ->matching('Users', function (Query $q) use ($user) {
                return $q
                    ->where([
                        'Users.id =' => $user['id'],
                    ]);
            });

        $this->set(
            compact(
                'playerCharacter',
                'characterClasses',
                'characterRaces',
                'campaigns',
                'alignments'
            )
        );
    }

    /**
     * Edit method
     *
     * @param string|null $id Player Character id.
     *
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $playerCharacter = $this->playerCharactersTable->get(
            $id,
            [
                'contain' => [
                    'CharacterClasses',
                    'CharacterRaces',
                    'Alignments',
                ],
            ]
        );

        if ($this->request->is(['patch', 'post', 'put'])) {
            $playerCharacter = $this->playerCharactersTable->patchEntity($playerCharacter, $this->request->getData());
            if ($this->playerCharactersTable->save($playerCharacter)) {
                $this->Flash->success(__('The player character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The player character could not be saved. Please, try again.'));
        }

        $user = $this->getUserOrRedirect();

        $characterClasses = $this->playerCharactersTable->CharacterClasses
            ->find('list', ['limit' => 200])
            ->order(['name' => 'ASC']);
        $characterRaces   = $this->playerCharactersTable->CharacterRaces
            ->find('list', ['limit' => 200])
            ->order(['name' => 'ASC']);
        $alignments       = $this->playerCharactersTable->Alignments
            ->find('list', ['limit' => 200]);
        $campaigns        = $this->playerCharactersTable->Campaigns
            ->find('list', ['limit' => 200])
            ->where(['Campaigns.user_id =' => $user['id']])
            ->order(['name' => 'ASC']);

        $this->set(
            compact(
                'playerCharacter',
                'characterClasses',
                'characterRaces',
                'campaigns',
                'alignments'
            )
        );
    }

    /**
     * Delete method
     *
     * @param string|null $id Player Character id.
     *
     * @return Response|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $playerCharacter = $this->playerCharactersTable->get($id);

        if ($this->playerCharactersTable->delete($playerCharacter)) {
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

        // Check that the playerCharacters belongs to the current user
        $playerCharacters = $this->playerCharactersTable->findById($id)->firstOrFail();

        return $playerCharacters->user_id === $user['id'];
    }
}
