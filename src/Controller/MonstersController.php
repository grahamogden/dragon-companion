<?php

namespace App\Controller;

use App\Model\Entity\Monster;
use App\Model\Entity\MonsterInstanceType;
use App\Model\Table\MonstersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\Network\Exception\NotFoundException;

/**
 * Monsters Controller
 *
 * @property MonstersTable $Monsters
 *
 * @method Monster[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class MonstersController extends AppController
{
    public $paginate = [
        'limit'         => 50,
        'order'         => [
            'name' => 'asc',
        ],
        'sortWhitelist' => [
            'name',
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

        $monsters = $this->Monsters->find()
            ->where(
                [
                    'OR' => [
                        'visibility' => 'public',
                        [
                            'visibility' => 'private',
                            'user_id'    => $user['id'],
                        ],
                    ],
                ]
            )
            ->contain(['MonsterInstanceTypes']);

        $monstersPaginated = $this->paginate($monsters);

        $this->set('monsters', $monstersPaginated);
        $this->set(compact('user'));
    }

    /**
     * View method
     *
     * @param string|null $id Monster id.
     *
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $monster = $this->Monsters->get(
            $id,
            [
                'contain' => [
                    'Alignments',
                    'DataSources',
                    'MonsterInstanceTypes',
                ],
            ]
        );

        $this->set('monster', $monster);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $monster = $this->Monsters->newEntity();
        $user = $this->getUserOrRedirect();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user_id'] = $user['id'];

            $monster = $this->Monsters->patchEntity($monster, $data);
            if ($this->Monsters->save($monster)) {
                $this->Flash->success(__('The monster has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The monster could not be saved. Please, try again.'));
        }

        $dataSources          = $this->Monsters->DataSources->find('list', ['limit' => 200]);
        $alignments           = $this->Monsters->Alignments->find('list', ['limit' => 200]);
        $monsterInstanceTypes = $this->Monsters->MonsterInstanceTypes->find(
            'list',
            [
                'limit'      => 200,
                'valueField' => static function (MonsterInstanceType $monsterInstanceType) {
                    return $monsterInstanceType->getLabel();
                },
            ]
        );

        $this->set(
            compact(
                'monster',
                'dataSources',
                'monsterInstanceTypes',
                'alignments'
            )
        );
    }

    /**
     * Edit method
     *
     * @param string|null $id Monster id.
     *
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $monster = $this->Monsters->get(
            $id,
            [
                'contain' => [],
            ]
        );
        if ($this->request->is(['patch', 'post', 'put'])) {
            $monster = $this->Monsters->patchEntity($monster, $this->request->getData());
            if ($this->Monsters->save($monster)) {
                $this->Flash->success(__('The monster has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The monster could not be saved. Please, try again.'));
        }

        $dataSources          = $this->Monsters->DataSources->find('list', ['limit' => 200]);
        $alignments           = $this->Monsters->Alignments->find('list', ['limit' => 200]);
        $monsterInstanceTypes = $this->Monsters->MonsterInstanceTypes->find('list', ['limit' => 200]);

        $this->set(
            compact(
                'monster',
                'dataSources',
                'monsterInstanceTypes',
                'alignments'
            )
        );
    }

    /**
     * Delete method
     *
     * @param string|null $id Monster id.
     *
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $monster = $this->Monsters->get($id);
        if ($this->Monsters->delete($monster)) {
            $this->Flash->success(__('The monster has been deleted.'));
        } else {
            $this->Flash->error(__('The monster could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Determines whether the user is authorised to be able to use this action
     *
     * @param array $user
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
                'view',
            ]
        )) {
            return true;
        }

        // All other actions require an item ID
        $id = $this->request->getParam('id');

        if (!$id) {
            return false;
        }

        // Check that the monsters belongs to the current user
        $monsters = $this->Monsters->findById($id)->firstOrFail();

        return $monsters->user_id === $user['id'] && $monsters->visibility === Monster::VISIBILITY_PRIVATE;
    }
}
