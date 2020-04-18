<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 *
 * @method \App\Model\Entity\Tag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TagsController extends AppController
{
    const CONTROLLER_NAME = 'Tags';
    public $paginate = [
        'limit' => 50,
        'order' => [
            'Tags.title' => 'asc'
        ],
        'sortWhitelist' => [
            'Tags.title',
        ],
    ];

    /**
     * Initialises the class, including authentication
     * 
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $user = $this->getUserOrRedirect();

        $tags = $this->Tags
            ->find()
            ->where(['tags.user_id =' => $user['id']]);

        $tags = $this->paginate($tags);

        $this->set(compact('tags'));
        $this->set('title', self::CONTROLLER_NAME);
    }

    /**
     * View method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tag = $this->Tags->get($id, [
            'contain' => ['TimelineSegments']
        ]);

        $this->set('tag', $tag);
        $this->set('title', sprintf(
            'View %s - %s',
            self::CONTROLLER_NAME,
            $tag->title
        ));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tag = $this->Tags->newEntity();
        if ($this->request->is('post')) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag, {0}, has been saved.', $tag->title));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $timelineSegments = $this->Tags->TimelineSegments->find('list', ['limit' => 200]);

        $this->set(compact('tag', 'timelineSegments'));
        $this->set('title', sprintf(
            'Add %s - %s',
            self::CONTROLLER_NAME,
            $tag->title
        ));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tag = $this->Tags->get($id, [
            'contain' => ['TimelineSegments']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag, {0}, has been saved.', $tag->title));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $timelineSegments = $this->Tags->TimelineSegments->find('list', ['limit' => 200]);

        $this->set(compact('tag', 'timelineSegments'));
        $this->set('title', sprintf(
            'Edit %s - %s',
            self::CONTROLLER_NAME,
            $tag->title
        ));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('The tag, {0}, has been deleted.', $tag->title));
        } else {
            $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
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
        $tags = $this->Tags->findById($id)->firstOrFail();

        return $tags->user_id === $user['id'];
    }
}
