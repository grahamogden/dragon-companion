<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Campaigns Controller
 *
 * @property \App\Model\Table\CampaignsTable $Campaigns
 *
 * @method \App\Model\Entity\Campaign[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampaignsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Clans'],
        ];

        $user = $this->getUserOrRedirect();

        $campaigns = $this->Campaigns->find()
            ->where(['Campaigns.user_id =' => $user['id']]);

        $campaignsPaginated = $this->paginate($campaigns);

        $this->set('campaigns', $campaignsPaginated);
    }

    /**
     * View method
     *
     * @param string|null $id Campaign id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $campaign = $this->Campaigns->get($id, [
            'contain' => ['Users', 'Clans'],
        ]);

        $this->set('campaign', $campaign);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $campaign = $this->Campaigns->newEntity();

        if ($this->request->is('post')) {
            $user = $this->getUserOrRedirect();
            $data = $this->request->getData();
            $data['user_id'] = $user['id'];

            $campaign = $this->Campaigns->patchEntity($campaign, $data);
            if ($this->Campaigns->save($campaign)) {
                $this->Flash->success(__('The campaign has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The campaign could not be saved. Please, try again.'));
        }

        $this->loadModel('Clans');
        $user = $this->getUserOrRedirect();

        $clans = $this->Clans->find('list', ['limit' => 200])
            ->where(['Clans.user_id =' => $user['id']]);
        $this->set(compact('campaign', 'clans'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Campaign id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $campaign = $this->Campaigns->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->getUserOrRedirect();
            $data = $this->request->getData();
            $data['user_id'] = $user['id'];

            $campaign = $this->Campaigns->patchEntity($campaign, $data);
            if ($this->Campaigns->save($campaign)) {
                $this->Flash->success(__('The campaign has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The campaign could not be saved. Please, try again.'));
        }

        $this->loadModel('Clans');
        $user = $this->getUserOrRedirect();

        $clans = $this->Clans->find('list', ['limit' => 200])
            ->where(['Clans.user_id =' => $user['id']]);
        $this->set(compact('campaign', 'clans'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Campaign id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
            in_array($action, [
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

        // Check that the timelineSegment belongs to the current user
        $campaign = $this->Campaigns->findById($id)->firstOrFail();

        return $campaign->user_id === $user['id'];
    }
}
