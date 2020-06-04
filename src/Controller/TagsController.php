<?php

namespace App\Controller;

use App\Model\Entity\Tag;
use App\Model\Table\TagsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\Network\Exception\NotFoundException;
use Exception;

/**
 * Tags Controller
 *
 * @property TagsTable $Tags
 *
 * @method Tag[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class TagsController extends AppController
{
    private const CONTROLLER_NAME = 'Tags';
    public $paginate = [
        'limit'         => 50,
        'order'         => [
            'Tags.title' => 'asc',
        ],
        'sortWhitelist' => [
            'Tags.title',
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

        $tags = $this->Tags
            ->find()
            ->where(['Tags.user_id =' => $user['id']]);

        $tags = $this->paginate($tags);

        $this->set(compact('tags'));
        $this->set('title', self::CONTROLLER_NAME);
    }

    /**
     * View method
     *
     * @param string|null $id Tag id.
     *
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tag = $this->Tags->get(
            $id,
            [
                'contain' => ['TimelineSegments'],
            ]
        );

        $this->set('tag', $tag);
        $this->set(
            'title',
            sprintf(
                'View %s - %s',
                self::CONTROLLER_NAME,
                $tag->title
            )
        );
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tag  = $this->Tags->newEntity();
        $user = $this->getUserOrRedirect();

        if ($this->request->is('post')) {
            $data            = $this->request->getData();
            $data['user_id'] = $user['id'];
            $tag             = $this->Tags->patchEntity($tag, $data);

            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag, {0}, has been saved.', $tag->title));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $timelineSegments = $this->Tags->TimelineSegments->find('list', ['limit' => 200]);

        $this->set(compact('tag', 'timelineSegments'));
        $this->set(
            'title',
            sprintf(
                'Add %s - %s',
                self::CONTROLLER_NAME,
                $tag->title
            )
        );
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag id.
     *
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tag = $this->Tags->get(
            $id,
            [
                'contain' => ['TimelineSegments'],
            ]
        );
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
        $this->set(
            'title',
            sprintf(
                'Edit %s - %s',
                self::CONTROLLER_NAME,
                $tag->title
            )
        );
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag id.
     *
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
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

        // Check that the timelineSegment belongs to the current user
        $tags = $this->Tags->findById($id)->firstOrFail();

        return $tags->user_id === $user['id'];
    }
}
