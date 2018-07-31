<?php
namespace App\Controller;

use App\Controller\AppController;
// use Cake\View\Helper\BreadcrumbsHelper;

/**
 * TimelineSegments Controller
 *
 * @property \App\Model\Table\TimelineSegmentsTable $TimelineSegments
 *
 * @method \App\Model\Entity\TimelineSegment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TimelineSegmentsController extends AppController
{

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
        $this->Auth->allow(['tags','reorder','getTags']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(): void
    {
        $this->paginate = [
            'contain' => ['ParentTimelineSegments', 'Users']
        ];
        $timelineSegments = $this->TimelineSegments
            ->find()
            ->where(['TimelineSegments.parent_id IS' => null])
            ->order('TimelineSegments.lft asc');

        $timelineSegments = $this->paginate($timelineSegments);

        $this->set('childTimelineSegments', $timelineSegments);
    }

    /**
     * View method
     *
     * @param int $id Timeline Segment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(int $id = null)
    {
        $timelineSegment = $this->TimelineSegments->get($id, [
            'contain' => [
                'ParentTimelineSegments',
                'Users',
                'Tags',
                'ChildTimelineSegments' => [
                    'sort' => ['lft' => 'ASC']
            ]],
        ]);

        $this->set('breadcrumbs', $this->TimelineSegments->find('path', ['for' => $id ? : 0]));
        $this->set('timelineSegment', $timelineSegment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $timelineSegment = $this->TimelineSegments->newEntity();
        if ($this->request->is('post')) {
            $timelineSegment = $this->TimelineSegments->patchEntity($timelineSegment, $this->request->getData());
            // Set the user ID on the item
            $timelineSegment->user_id = $this->Auth->user('id');

            if ($this->TimelineSegments->save($timelineSegment)) {
                $this->Flash->success(__('The timeline segment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The timeline segment could not be saved. Please, try again.'));
        }

        $parentTimelineSegments = $this->TimelineSegments->ParentTimelineSegments->find('treeList', [
            'limit' => 200,
            'spacer' => '↳ ',
        ]);
        $users = $this->TimelineSegments->Users->find('list', ['limit' => 200]);
        $tags = $this->TimelineSegments->Tags->find('list', [
            'limit' => 200,
            'order' => ['Tags.title' => 'ASC'], // TODO: it appears as though the ordering is being ignored, need to look into this
        ]);

        $this->set(compact('timelineSegment', 'parentTimelineSegments', 'users', 'tags'));
    }

    /**
     * Edit method
     *
     * @param int $id Timeline Segment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit(int $id = null)
    {
        $timelineSegment = $this->TimelineSegments->get($id, [
            'contain' => ['Tags']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $timelineSegment = $this->TimelineSegments->patchEntity($timelineSegment, $this->request->getData());
            if ($this->TimelineSegments->save($timelineSegment)) {
                $this->Flash->success(__('The timeline segment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The timeline segment could not be saved. Please, try again.'));
        }
        $parentTimelineSegments = $this->TimelineSegments->ParentTimelineSegments->find('treeList', [
            'limit' => 200,
            'spacer' => '↳ ',
        ]);
        $users = $this->TimelineSegments->Users->find('list', ['limit' => 200]);
        $tags = $this->TimelineSegments->Tags->find('list', [
            'limit' => 200,
            'order' => ['Tags.title' => 'ASC'], // TODO: it appears as though the ordering is being ignored, need to look into this
        ]);

        $this->set('breadcrumbs', $this->TimelineSegments->find('path', ['for' => $id ? : 0]));
        $this->set(compact('timelineSegment', 'parentTimelineSegments', 'users', 'tags'));
    }

    /**
     * Delete method
     *
     * @param int $id Timeline Segment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(int $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $timelineSegment = $this->TimelineSegments->get($id);
        if ($this->TimelineSegments->delete($timelineSegment)) {
            $this->Flash->success(__('The timeline segment has been deleted.'));
        } else {
            $this->Flash->error(__('The timeline segment could not be deleted. Please, try again.'));
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
        if (in_array($action, [
            'add', 'tags', 'getTags',
        ])) {
            return true;
        }

        // All other actions require an item ID
        $id = $this->request->getParam('id');

        if (!$id) {
            return false;
        }

        // Check that the timelineSegment belongs to the current user
        $timelineSegment = $this->TimelineSegments->findById($id)->firstOrFail();

        return $timelineSegment->user_id === $user['id'];
    }


    public function moveUp(int $id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $timelineSegment = $this->TimelineSegments->get($id);
        if ($this->TimelineSegments->moveUp($timelineSegment)) {
            $this->Flash->success('The timeline segment has been moved Up.');
        } else {
            $this->Flash->error('The timeline segment could not be moved up. Please, try again.');
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }


    public function moveDown(int $id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $timelineSegment = $this->TimelineSegments->get($id);
        if ($this->TimelineSegments->moveDown($timelineSegment)) {
            $this->Flash->success('The timeline segment has been moved down.');
        } else {
            $this->Flash->error('The timeline segment could not be moved down. Please, try again.');
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Looks up tags based on a wildcard search term,
     * starting with at least three character
     * 
     * @return string
     */
    public function getTags()
    {
        $this->autoRender = false;

        $term = $this->request->getQuery('term');

        if ($this->request->is('ajax') && strlen($term) >= 3) {
            $results = $this->TimelineSegments->Tags->find('all', [
                'conditions' => ['Tags.title LIKE' => '%' . $term . '%']
            ]);

            $tags = [];
            foreach ($results as $result) {
                $tags[] = [
                    'responseCode' => 200,
                    'label'        => $result->title,
                    'value'        => $result->title,
                ];
            }
        } else {
            $tags = [
                'responseCode' => 404,
                'label'        => 'No results found',
                'value'        => '',
            ];
        }

        echo json_encode($tags);
    }
}
