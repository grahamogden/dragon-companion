<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Clan;
use App\Model\Entity\ClansUser;
use App\Model\Table\ClansTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

/**
 * Clans Controller
 *
 * @property ClansTable $Clans
 *
 * @method Clan[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClansController extends AppController
{
    /**
     * Index method
     *
     * @return Response|null
     */
    public function index()
    {
        $userId = $this->Auth->user('id');
        $query  = $this->Clans->find()->matching(
            'Users',
            function ($q) use ($userId) {
                return $q->where(['Users.id =' => $userId]);
            }
        );
        $clans  = $this->paginate($query);

        $this->set(compact('clans', 'userId'));
    }

    /**
     * View method
     *
     * @param string|null $id Clan id.
     *
     * @return Response|null
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clan = $this->Clans->get(
            $id,
            [
                'contain' => ['Users'],
            ]
        );

        $adminUsers  = [];
        $memberUsers = [];

        foreach ($clan->users as $user) {
            if ($user->_joinData->account_level === ClansUser::ACCOUNT_LEVEL_ADMIN) {
                $adminUsers[] = $user;
            } else {
                $memberUsers[] = $user;
            }
        }

        $this->set(compact('clan', 'adminUsers', 'memberUsers'));
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clan = $this->Clans->newEntity();
        if ($this->request->is('post')) {
            $userId          = $this->Auth->user('id');
            $data            = $this->request->getData();
            $data['users']   = [
                [
                    'id'        => $userId,
                    '_joinData' => [
                        'user_id'       => $userId,
                        'member_status' => 1,
                        'account_level' => 10,
                    ],
                ],
            ];
            $data['user_id'] = $userId;

            $clan = $this->Clans->newEntity(
                $data,
                [
                    'associated' => ['Users._joinData'],
                ]
            );

            if ($this->Clans->save($clan)) {
                $this->Flash->success(__('The clan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clan could not be saved. Please, try again.'));
        }
        $users = $this->Clans->Users->find('list', ['limit' => 200])->where(['id !=' => $this->Auth->user('id')]);

        $this->set(compact('clan', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Clan id.
     *
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public
    function edit(
        $id = null
    ) {
        $clan = $this->Clans->get(
            $id,
            [
                'contain' => ['Users'],
            ]
        );

        if ($this->request->is(['patch', 'post', 'put'])) {

            $clan = $this->Clans->patchEntity($clan, $this->request->getData());
            if ($this->Clans->save($clan)) {
                $this->Flash->success(__('The clan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clan could not be saved. Please, try again.'));
        }

        $adminUsers = [];
        foreach ($clan->users as $user) {
            if ($user->_joinData->account_level === ClansUser::ACCOUNT_LEVEL_ADMIN) {
                $adminUsers[] = $user;
            }
        }

        $this->set(compact('clan', 'adminUsers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Clan id.
     *
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public
    function delete(
        $id = null
    ) {
        $this->request->allowMethod(['post', 'delete']);
        $clan = $this->Clans->get($id);
        if ($this->Clans->delete($clan)) {
            $this->Flash->success(__('The clan has been deleted.'));
        } else {
            $this->Flash->error(__('The clan could not be deleted. Please, try again.'));
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
    public
    function isAuthorized(
        $user
    ): bool {
        $action = $this->request->getParam('action');
        // The add and index actions are always allowed to logged in users
        if (in_array(
            $action,
            [
                'add',
                'index',
                'addClanUser',
                'getUsers',
            ]
        )) {
            return true;
        }

        // All other actions require an item ID
        $id = $this->request->getParam('id');

        if (!$id) {
            return false;
        }

        // Check that the clans belongs to the current user
        $clan        = $this->Clans->findById($id)->contain('Users')->firstOrFail();
        $clanUserIds = array_column($clan->users, 'id');

        return $clan->user_id === $user['id'] || in_array($user['id'], $clanUserIds);
    }

    /**
     * Looks up tags based on a wildcard search term,
     * starting with at least three character
     *
     * @return string
     */
    public
    function getUsers(): void
    {
        $this->autoRender = false;
        $term             = $this->request->getQuery('term');

        if ($this->request->is('ajax') && strlen($term) >= 3) {

            $excludes      = json_decode($this->request->getQuery('excludes'), true);
            $excludeClanId = $excludes['clanId'];
            if (!is_numeric($excludeClanId)) {
                header('HTTP/1.0 400 Bad request');
            }

            $this->loadModel('Users');

            $results = $this->Users->find()
                ->notMatching(
                    'Clans',
                    function (Query $q) use ($excludeClanId) {
                        return $q->where(['Clans.id =' => $excludeClanId]);
                    }
                )
                ->where(['Users.username LIKE' => $term . '%'])
                ->limit(20);

            foreach ($results as $result) {
                $return[] = [
                    'label' => $result->username,
                    'value' => $result->username,
                ];
            }
        } else {
            $return = [
                'label' => 'No results found',
                'value' => 'No results found',
            ];
        }

        echo json_encode($return);
        exit;
    }
}
