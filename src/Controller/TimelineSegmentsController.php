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
        $parentId = $this->request->getQuery('parentId');

        if (!isset($parentId)) {
            $parentId = 0;
        }

        // Get the timeline segments for this parent ID
        $timelineSegments = $this->TimelineSegments->find('ByParentId', [
            'parentId' => $parentId,
        ]);

        // Get the parent timeline segment
        $parentTimelineSegment = $this->TimelineSegments
            ->findById($parentId)
            ->first();

        // Get breadcrumbs
        $breadcrumbs = $this->fetchAncestorBreadcrumbs($parentId);

        // $timelineSegments = $this->Paginator->paginate($this->TimelineSegments->find());
        $this->set('parent', $parentTimelineSegment);
        $this->set('parentId', $parentId);
        $this->set('breadcrumbs', $breadcrumbs);
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
     * @return void|\Cake\Http\Response
     */
    public function add()
    {
        // Get the parent ID
        $parentId   = $this->request->getQuery('parentId') ?? 0;
        // Get the ID of the previous item that this item will point to
        $previousId = $this->request->getQuery('previousId') ?? 0;
        // Get the ID of the next item that will point to this item
        $nextId     = $this->request->getQuery('nextId') ?? 0;

        $newTimelineSegment = $this->TimelineSegments->newEntity();
        if ($this->request->is('post')) {
            $success = false;

            // Updates the entity with the POST data
            $newTimelineSegment = $this->TimelineSegments->patchEntity($newTimelineSegment, $this->request->getData());

            // If we have a parent ID, then set it
            if ($parentId) {
                $newTimelineSegment->parent_id = $parentId;
            }

            // If we have a next ID, then set it
            if ($previousId) {
                $newTimelineSegment->previous_id = $previousId;
            }

            // Set the user ID on the item
            $newTimelineSegment->user_id = $this->Auth->user('id');

            if ($this->TimelineSegments->save($newTimelineSegment)) {
                // If we have a next ID, then get the next timeline segment and update it to point to the new one
                if ($nextId) {
                    $nextTimelineSegment = $this->TimelineSegments
                        ->findById($nextId)
                        ->firstOrFail();

                    $this->TimelineSegments->patchEntity($nextTimelineSegment, [
                        'previous_id' => $newTimelineSegment->id
                    ]);

                    if ($this->TimelineSegments->save($nextTimelineSegment)) {
                        $success = true;
                    }
                } else {
                    $success = true;
                }
            }

            if ($success) {
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
        $this->set('breadcrumbs', $this->fetchAncestorBreadcrumbs($parentId));
        $this->set('timelineSegment', $newTimelineSegment);
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
        $this->set('breadcrumbs', $this->fetchAncestorBreadcrumbs($timelineSegment->parent_id));
        $this->set('timelineSegment', $timelineSegment);
        $this->render('/TimelineSegments/add');
        // $this->viewBuilder()->setLayout('add');
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
        $timelineSegmentToUpdate = $this->TimelineSegments->find('ByPreviousId', [
                'previousId' => $timelineSegmentToDelete->id
            ]);

        $this->TimelineSegments->patchEntity($timelineSegmentToUpdate, [
            'previous_id' => $timelineSegmentToDelete->previous_id
        ]);

        if ($this->TimelineSegments->save($timelineSegmentToUpdate)
            && $this->TimelineSegments->delete($timelineSegmentToDelete)
        ) {
            $this->Flash->success(__('The {0} timeline segment has been deleted.', $timelineSegmentToDelete->title));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('The {0} timeline segment could not be deleted.', $timelineSegmentToDelete->title));
            return $this->redirect(['aciton' => 'index']);
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
        /*
         * TODO: We need to update 4 records(!) not just three because:
         * eg. move up
         * id | previous_id
         *  1 | 0
         *  2 | 1
         *  3 | 2 <- target segment - moves up
         *  4 | 3
         *  = (which equals or will become...)
         * id order OR previous id order (which is what is visible to the user)
         *  1 | 0        1 | 0
         *  2 | 3   OR   3 | 1
         *  3 | 1        2 | 3
         *  4 | 2        4 | 2
         *
         * eg. move down
         * id | previous_id
         *  1 | 0
         *  2 | 1 <- target segment - moves up
         *  3 | 2
         *  4 | 3
         *  = (which equals or will become...)
         * id order OR previous id order (which is what is visible to the user)
         *  1 | 0        1 | 0
         *  2 | 3   OR   3 | 1
         *  3 | 1        2 | 3
         *  4 | 2        4 | 2
         * 
         * ... Mind-blown... Moving something up or down is irrelevant,
         * because something moving up is something else moving down...
         */

        // Get the current timeline segment we are going to update
        $aboveTimelineSegment = $this->TimelineSegments->findById($id)->firstOrFail();
        // Get the timeline segment that the middle segment is pointing to
        // $middleTimelineSegment = $this->TimelineSegments->findById($aboveTimelineSegment->previous_id)->firstOrFail();
        $middleTimelineSegment = $this->TimelineSegments->find(
            'ByPreviousId', [
                'previousId' => $aboveTimelineSegment->id
        ]);

        // pr($aboveTimelineSegment);
        // pr($middleTimelineSegment);

        if ($middleTimelineSegment) {
            // pr('Gone into middle - true');
            // Point the middle item to where the above item was pointing to
            $this->TimelineSegments->patchEntity($middleTimelineSegment, [
                'previous_id' => ($aboveTimelineSegment ? $aboveTimelineSegment->previous_id : 0)
            ]);

            // pr('Update middle');
            // pr($middleTimelineSegment);

            if ($aboveTimelineSegment) {
                // pr('Gone into above - true');
                // Point the above item to the middle item
                $this->TimelineSegments->patchEntity($aboveTimelineSegment, [
                    'previous_id' => $middleTimelineSegment->id
                ]);
                // pr('Updated above');
                // pr($aboveTimelineSegment);
            }

            // Get the timeline segment that is pointing to the middle segment
            $belowTimelineSegment = $this->TimelineSegments->find(
                'ByPreviousId', [
                    'previousId' => $middleTimelineSegment->id
            ]);
            // pr($belowTimelineSegment);

            if ($belowTimelineSegment) {
                // pr('Gone into below - true');
                // Point the below item to the above item
                $this->TimelineSegments->patchEntity($belowTimelineSegment, [
                    'previous_id' => $aboveTimelineSegment->id
                ]);
                // pr('Updated below');
                // pr($belowTimelineSegment);
            }

            // pr($aboveTimelineSegment);
            // pr($middleTimelineSegment);
            // pr($belowTimelineSegment);
            // exit();

            if ($this->TimelineSegments->save($middleTimelineSegment)
                && $this->TimelineSegments->save($aboveTimelineSegment)
            ) {
                $this->Flash->success(__('The timeline segments have been reordered.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The timeline segments could not be reordered.'));
                return $this->redirect(['aciton' => 'index']);
            }
        } else {
            $this->Flash->error(__('The timeline segments could not be reordered.'));
        }
    }
}
