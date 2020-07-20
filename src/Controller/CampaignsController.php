<?php

namespace App\Controller;

use App\Application;
use App\Model\Entity\Campaign;
use App\Model\Entity\CampaignUser;
use App\Model\Table\CampaignsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

/**
 * Campaigns Controller
 *
 * @property CampaignsTable $Campaigns
 *
 * @method Campaign[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampaignsController extends AppController
{

    /**
     * Index method
     *
     * @return Response|null
     */
    public function index()
    {
//        $this->paginate = [
//            'contain' => ['Users'],
//        ];

        $user = $this->getUserOrRedirect();

        $campaigns = $this->Campaigns->find()->matching(
            'Users',
            function (Query $q) use ($user) {
                return $q->where(['Users.id =' => $user['id']]);
            }
        );

        $campaignsPaginated = $this->paginate($campaigns);

        $this->set('campaigns', $campaignsPaginated);
    }

    /**
     * View method
     *
     * @param string|null $id Campaign id.
     *
     * @return void
     */
    public function view($id = null)
    {
        $campaign = $this->Campaigns->get(
            $id,
            [
                'contain' => ['Users', /*'Clans'*/],
            ]
        );

        $this->set('campaign', $campaign);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $campaign = $this->Campaigns->newEntity();

        if ($this->request->is('post')) {
            $user          = $this->getUserOrRedirect();
            $data          = $this->request->getData();
            $data['users'] = [
                [
                    'id'        => $user['id'],
                    '_joinData' => [
                        'user_id'       => $user['id'],
                        'member_status' => CampaignUser::MEMBER_STATUS_ACTIVE,
                        'account_level' => CampaignUser::ACCOUNT_LEVEL_CREATOR,
                    ],
                ],
            ];

//            $clan = $this->Clans->newEntity(
//                $data,
//                [
//                    'associated' => ['Users._joinData'],
//                ]
//            );

            $campaign = $this->Campaigns->patchEntity($campaign, $data);
            if ($this->Campaigns->save($campaign)) {
                $this->Flash->success(__('The campaign has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The campaign could not be saved. Please, try again.'));
        }

//        $this->loadModel('Users');
//        $user = $this->getUserOrRedirect();
//
//        $users = $this->Users->find('list', ['limit' => 200])
//            ->where(['Users.user_id =' => $user['id']]);
        $this->set(compact('campaign'/*, 'users'*/));
    }

    /**
     * Edit method
     *
     * @param string|null $id Campaign id.
     *
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
       $this->loadModel('Users');

        $campaign = $this->Campaigns->get(
            $id,
            [
                'contain' => ['Users',],
            ]
        );

        $campaignUserCreator = $this->Users->find()
            ->matching('Campaigns', function (Query $q) use ($campaign) {
                return $q
                    ->where([
                        'Campaigns.id =' => $campaign['id'],
                    ]);
            })
            ->where(['CampaignUsers.account_level =' => CampaignUser::ACCOUNT_LEVEL_CREATOR,])
            ->firstOrFail();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user            = $this->getUserOrRedirect();
            $data            = $this->request->getData();
            
            $usersJson = json_decode($data['users_string'], true);
// debug($campaignUserCreator);
            $data['users'][] = [
                'id'        => $campaignUserCreator['id'],
                '_joinData' => [
                    'user_id'       => $campaignUserCreator['id'],
                    'member_status' => $campaignUserCreator['_matchingData']['CampaignUsers']->member_status,
                    'account_level' => $campaignUserCreator['_matchingData']['CampaignUsers']->account_level,
                ],
            ];

            foreach ($usersJson as $userJson) {
                $data['users'][] = [
                    'id'        => $userJson['value'],
                    '_joinData' => [
                        'user_id'       => $userJson['value'],
                        'member_status' => CampaignUser::MEMBER_STATUS_PENDING,
                        'account_level' => CampaignUser::ACCOUNT_LEVEL_USER,
                    ],
                ];
            }
            $campaign = $this->Campaigns->patchEntity($campaign, $data);
// debug($campaign);exit;
            if ($this->Campaigns->save($campaign)) {
                $this->Flash->success(__('The campaign has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The campaign could not be saved. Please, try again.'));
        }

        $campaignUsers = $this->Users->find('list')
            ->matching('Campaigns', function (Query $q) use ($campaign) {
                return $q
                    ->where([
                        'Campaigns.id =' => $campaign['id'],
                    ]);
            })
            ->where(['CampaignUsers.account_level !=' => CampaignUser::ACCOUNT_LEVEL_CREATOR,]);

        $this->set(compact('campaign', 'campaignUsers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Campaign id.
     *
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $campaign = $this->Campaigns->get($id);
        if ($this->Campaigns->delete($campaign)) {
            $this->Flash->success(__('The campaign has been deleted.'));
        } else {
            $this->Flash->error(__('The campaign could not be deleted. Please, try again.'));
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

        // The add and tags actions are always allowed to logged in users
        if (
        in_array(
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

        try {
            // Check that the timelineSegment belongs to the current user
            $campaign = $this->Campaigns->findById($id)->matching('Users', function (Query $q) use ($user) {
                return $q
                    ->where(['Users.id' => $user['id']]);
            })->firstOrFail();
        } catch (RecordNotFoundException $e) {
            return false;
        }

        return true;
    }

    public function selectCampaign($id = null)
    {
        // debug('selectCampaign');
        if ($this->request->is(['post',])) {
            $user = $this->getUserOrRedirect();
            $data = $this->request->getData();

            try {
                // Check that the timelineSegment belongs to the current user
                $campaign = $this->Campaigns->findById($id)->matching('Users', function (Query $q) use ($user) {
                    return $q
                        ->where(['Users.id' => $user['id']]);
                })->firstOrFail();

                // debug($campaign);
                // debug($user);
                if ($campaign && $campaign['id']) {
                    // exit;
                    $this->getRequest()->getSession()->write(Application::SESSION_KEY_CAMPAIGN, $campaign);

                    return $this->redirect(
                        [
                            '_name' => 'TimelineSegmentsIndex',
                            'campaignId' => $campaign->id,
                        ]
                    );
                }
            } catch (RecordNotFoundException $e) {
                return false;
            }

            $this->Flash->error(__('The campaign could not be opened. Please, try again.'));
        }
        return $this->redirect($this->Auth->logout());
    }

}
