<?php

namespace App\Controller;

use App\Controller\AppController;

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
        $timelineSegments = $this->Paginator->paginate($this->TimelineSegments->find());
        $this->set(compact('timelineSegments'));
    }

    public function view($slug)
    {
        $timelineSegment = $this->TimelineSegments->findBySlug($slug)->firstOrFail();
        $this->set(compact('timelineSegment'));
    }

    public function add()
    {
        $timelineSegment = $this->TimelineSegments->newEntity();
        if ($this->request->is('post')) {
            $timelineSegment = $this->TimelineSegments->patchEntity($timelineSegment, $this->request->getData());

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

    public function edit($slug)
    {
        $timelineSegment = $this->TimelineSegments
            ->findBySlug($slug)
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
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);

        $timelineSegment = $this->TimelineSegments->findBySlug($slug)->firstOrFail();
        if ($this->TimelineSegments->delete($timelineSegment)) {
            $this->Flash->success(__('The {0} timeline Segment has been deleted.', $timelineSegment->title));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function tags(...$tags)
    {
        // Use the TimelineSegmentsTable to find tagged timelineSegments.
        $timelineSegments = $this->TimelineSegments->find('tagged', [
            'tags' => $tags
        ]);

        // Pass variables into the view template context.
        $this->set([
            'timelineSegments' => $timelineSegments,
            'tags' => $tags
        ]);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // The add and tags actions are always allowed to logged in users.
        if (in_array($action, ['add', 'tags'])) {
            return true;
        }

        // All other actions require a slug.
        $slug = $this->request->getParam('pass.0');
        if (!$slug) {
            return false;
        }

        // Check that the timelineSegment belongs to the current user.
        $timelineSegment = $this->TimelineSegments->findBySlug($slug)->first();

        return $timelineSegment->user_id === $user['id'];
    }

}
