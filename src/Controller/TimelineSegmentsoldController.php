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
        $this->Auth->allow(['tags','reorder']);
    }

    public function index()
    {
        $parentId = $this->request->getQuery('parentId') ?: null;

        // Get the timeline segments for this parent ID
        // $timelineSegments = $this->TimelineSegments->find('ByParentId', [
        //     'parentId' => $parentId,
        // ]);
// $timelineSegment = $this->TimelineSegments->get(1);
$timelineSegments = $this->TimelineSegments->find()
    ->order('previous_id ASC');
foreach($timelineSegments as $segment) {
    pr($segment);
}
exit;

        $timelineSegments = $this->TimelineSegments->find('children', [
            'for' => $parentId
        ]);
        //     'ByParentId', [
        //     'parentId' => $parentId
        // ]);

        if ($parentId) {
            // Get the parent timeline segment
            $parentTimelineSegment = $this->TimelineSegments
                ->findById($parentId)
                ->first();
        }

        // Get breadcrumbs
        // $breadcrumbs = $this->fetchAncestorBreadcrumbs($parentId);

        // $timelineSegments = $this->Paginator->paginate($this->TimelineSegments->find());
        if ($parentId) {
            $this->set('parent', $parentTimelineSegment);
        }
        $this->set('parentId', $parentId);
        if ($parentId) {
            $this->set('breadcrumbs', $this->TimelineSegments->find('path', ['for' => $parentId ? : 0]));//this->fetchAncestorBreadcrumbs($parentId));
        }
        $this->set(compact('timelineSegments'));
    }

    /**
     * @deprecated - no longer in use
     * 
     * @param type $id 
     * @return type
     */
    public function view($id)
    {
        $timelineSegment = $this->TimelineSegments
            ->findById($id)
            ->firstOrFail();
        $this->set(compact('timelineSegment'));
    }

    /**
     * Add route
     * 
     * @param int $parentId - ID of the timeline segment that the new item will be a child of
     * 
     * @return void|\Cake\Http\Response
     */
    public function add(int $parentId = null)
    {
        // Get the order number that the new item will be inserted into
        $orderNumber = $this->request->getQuery('order_number') ?? 0;

        $newTimelineSegment = $this->TimelineSegments->newEntity();
        if ($this->request->is('post')) {
            $success = false;

            // Updates the entity with the POST data
            $newTimelineSegment = $this->TimelineSegments->patchEntity($newTimelineSegment, $this->request->getData());
            $newTimelineSegment->parent_id     = $parentId;
            $newTimelineSegment->order_number  = $orderNumber;
            // Set the user ID on the item
            $newTimelineSegment->user_id = $this->Auth->user('id');

            // $this->TimelineSegments->updateAllOrder($parentId, $orderNumber);

            if ($this->TimelineSegments->save($newTimelineSegment)) {
                $this->Flash->success(__('Your timeline segment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Unable to add your timeline segment.'));
            }
        }

        // Get a list of tags.
        $tags = $this->TimelineSegments->Tags->find('list');

        // Set tags to the view context
        $this->set('tags', $tags);
        if ($parentId) {
            $this->set('breadcrumbs', $this->TimelineSegments->find('path', ['for' => $parentId ? : 0]));//this->fetchAncestorBreadcrumbs($parentId));
        }
        $this->set('orderNumber', $this->request->getQuery('orderNumber'));
        $this->set('timelineSegment', $newTimelineSegment);
    }

    /**
     * Delete action
     * 
     * @param int $id 
     * @return 
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $timelineSegmentToDelete = $this->TimelineSegments->findById($id)->firstOrFail();

        // $this->TimelineSegments->updateAllOrder($timelineSegmentToDelete->parent_id);

        if ($this->TimelineSegments->delete($timelineSegmentToDelete)) {
            $this->Flash->success(__('The {0} timeline segment has been deleted.', $timelineSegmentToDelete->title));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('The {0} timeline segment could not be deleted.', $timelineSegmentToDelete->title));
            return $this->redirect(['aciton' => 'index']);
        }
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

            $this->TimelineSegments->updateAllOrder($parentId);

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
        if ($parentId) {
            $this->set('breadcrumbs', $this->TimelineSegments->find('path', ['for' => $parentId ? : 0]));//this->fetchAncestorBreadcrumbs($parentId));
        }
        $this->set('timelineSegment', $timelineSegment);
        $this->render('/TimelineSegments/add');
        // $this->viewBuilder()->setLayout('add');
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
        $timelineSegments = $this->TimelineSegments->find('children', [
            'for' => $parentId
        ]);

        $this->set('timelineSegments', $timelineSegments);
        $this->set('parentId', $parentId);

        // $this->render('/TimelineSegments/index');
        $this->viewBuilder()->setLayout('index');
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // The add and tags actions are always allowed to logged in users
        if (in_array($action, [
            'add', 'tags'
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

    /**
     * Description
     * @param int $parentId 
     * @return type
     */
    private function fetchAncestorBreadcrumbs($parentId)
    {
        $breadcrumbs = [];

        // if ($parentId > 0) {
            while ($parentId != 0) {
                $item = $this->TimelineSegments
                    ->findById($parentId)
                    ->firstOrFail();

                $breadcrumbs[] = [
                    'title' => $item->title,
                    'url' => [
                        'controller' => 'timeline-segments',
                        'action' => 'index',
                        'parentId' => $item->id,
                    ],
                ];

                $parentId = $item->parent_id;
            }

            // Need to add the "home" at the end of the array because it will be reversed at the end
            $breadcrumbs[] = [
                'title' => 'Timeline Segments',
                'url' => [
                    'controller' => 'timeline-segments',
                    'action' => 'index',
                ]
            ];
        // }

        // Need to reverse the array because it finds the ancestors in nearest order first
        // - meaning that the direct parent will be added to the array first, and
        // subsequent parents will be added afterwards. Which would make the breadcrumbs
        // be in reverese order
        return array_reverse($breadcrumbs);
    }

    /**
     * Moves the item with the provided ID down in the stack
     * This will also act as a promotion for the item below it (if the ID was
     * the previous_id of the element that the user selected)
     * 
     * @param type $id - The ID of the item that will be moved down 
     * 
     * @return type
     */
    public function reorder($id)
    {
        // Get the current timeline segment we are going to update
        $timelineSegment/*Above*/ = $this->TimelineSegments->findById($id)->firstOrFail();

        $this->TimelineSegments->moveDown($timelineSegment);

        // $orderNumber = $timelineSegmentAbove->order_number;

        // // Get the current timeline segment we are going to update
        // $timelineSegmentBelow = $this->TimelineSegments->find('ByOrderNumber', [
        //     'order_number' => $orderNumber + 1
        // ]);

        // $this->TimelineSegments->patchEntity($timelineSegmentAbove, [
        //     'order_number' => $orderNumber + 1
        // ]);

        // $this->TimelineSegments->patchEntity($timelineSegmentBelow, [
        //     'order_number' => $orderNumber
        // ]);

        // if ($this->TimelineSegments->save($timelineSegmentAbove)
        //     && $this->TimelineSegments->save($timelineSegmentBelow)
        // ) {
        //     $this->Flash->success(__('The timeline segments have been reordered.'));
        //     return $this->redirect(['action' => 'index']);
        // } else {
        //     $this->Flash->error(__('The timeline segments could not be reordered.'));
        //     return $this->redirect(['aciton' => 'index']);
        // }
    }
}
