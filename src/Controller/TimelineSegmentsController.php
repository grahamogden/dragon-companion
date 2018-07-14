<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\View\Helper\BreadcrumbsHelper;

class TimelineSegmentsController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
        $this->Auth->allow(['tags']);
    }

    public function index()
    {
        $parentId = $this->request->getQuery('parentId');
        if (!isset($parentId)) {
            $parentId = 0;
        }

        $timelineSegments = $this->TimelineSegments->find('ByParentId', [
            'parentId' => $parentId,
        ]);

        $breadcrumbs = [];

        while ($parentId != 0) {
            $item = $this->TimelineSegments->find('AncestorByParentId', [
                'parentId' => $parentId,
            ]);

            $breadcrumbs[] = [
                'title' => substr($item->title, 0, 17) . '...',
                'url' => [
                    'controller' => 'timeline-segments',
                    'action' => 'index',
                    'parentId' => $item->parent_id,
                ],
            ];

            $parentId = $item->parent_id;
        }

        // $timelineSegments = $this->Paginator->paginate($this->TimelineSegments->find());
        $this->set('parentId', $parentId);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set(compact('timelineSegments'));
    }

    public function view($id)
    {
        $timelineSegment = $this->TimelineSegments->findById($id)->firstOrFail();
        $this->set(compact('timelineSegment'));
    }

    /**
     * Add route
     * 
     * @return void|\Cake\Http\Response|null
     */
    public function add()
    {
        $timelineSegment = $this->TimelineSegments->newEntity();
        if ($this->request->is('post')) {
            $timelineSegment = $this->TimelineSegments->patchEntity($timelineSegment, $this->request->getData());
            $parentId = $this->request->getQuery('parentId');

            if ($parentId) {
                $timelineSegment->parent_id = $parentId;
            }

            $timelineSegment->user_id = $this->Auth->user('id');

            if ($this->TimelineSegments->save($timelineSegment)) {
                $this->Flash->success(__('Your timelineSegment has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your timelineSegment.'));
        }
        // Get a list of tags.
        $tags = $this->TimelineSegments->Tags->find('list');

        // Set tags to the view context
        $this->set('tags', $tags);

        $this->set('timelineSegment', $timelineSegment);
    }

    /**
     * Edit route
     * 
     * @param int $id 
     * @return void|\Cake\Http\Response|null
     */
    public function edit(int $id)
    {
        $timelineSegment = $this->TimelineSegments
            ->findById($id)
            ->contain('Tags') // load associated Tags
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->TimelineSegments->patchEntity(
                $timelineSegment,
                $this->request->getData(),
                [
                    // Added: Disable modification of user_id.
                    'accessibleFields' => ['user_id' => false]
                ]
            );

            if ($this->TimelineSegments->save($timelineSegment)) {
                $this->Flash->success(__('Your timelineSegment has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your timelineSegment.'));
        }

        // Get a list of tags.
        $tags = $this->TimelineSegments->Tags->find('list');

        // Set tags to the view context
        $this->set('tags', $tags);

        $this->set('timelineSegment', $timelineSegment);
        $this->render('/TimelineSegments/add');
        // $this->viewBuilder()->setLayout('add');
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $timelineSegment = $this->TimelineSegments->findById($id)->firstOrFail();
        if ($this->TimelineSegments->delete($timelineSegment)) {
            $this->Flash->success(__('The {0} timeline Segment has been deleted.', $timelineSegment->title));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function tags(...$tags)
    {
        // Use the TimelineSegmentsTable to find tagged timelineSegments.
        $timelineSegments = $this->TimelineSegments->find('tagged', [
            'tags' => $tags,
        ]);

        // Pass variables into the view template context.
        $this->set([
            'timelineSegments' => $timelineSegments,
            'tags' => $tags,
        ]);
    }

    public function segments($parentId)
    {
        $timelineSegments = $this->TimelineSegments->find('ByParentId', [
            'parentId' => $parentId
        ]);

        $this->set('timelineSegments', $timelineSegments);
        $this->set('parentId', $parentId);

        // $this->render('/TimelineSegments/index');
        $this->viewBuilder()->setLayout('index');
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // The add and tags actions are always allowed to logged in users.
        if (in_array($action, ['add', 'tags'])) {
            return true;
        }

        // All other actions require a ID.
        $id = $this->request->getParam('pass.0');
        if (!$id) {
            return false;
        }

        $this->set('userId', $id);

        // Check that the timelineSegment belongs to the current user.
        $timelineSegment = $this->TimelineSegments->findById($id)->first();

        return $timelineSegment->user_id === $user['id'];
    }

}
