<?php
namespace App\Controller;

use App\Controller\AppController;

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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentTimelineSegments', 'Users']
        ];
        $timelineSegments = $this->paginate($this->TimelineSegments);

        $this->set(compact('timelineSegments'));
    }

    /**
     * View method
     *
     * @param string|null $id Timeline Segment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $timelineSegment = $this->TimelineSegments->get($id, [
            'contain' => ['ParentTimelineSegments', 'Users', 'Tags', 'ChildTimelineSegments']
        ]);

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
            if ($this->TimelineSegments->save($timelineSegment)) {
                $this->Flash->success(__('The timeline segment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The timeline segment could not be saved. Please, try again.'));
        }
        $parentTimelineSegments = $this->TimelineSegments->ParentTimelineSegments->find('list', ['limit' => 200]);
        $users = $this->TimelineSegments->Users->find('list', ['limit' => 200]);
        $tags = $this->TimelineSegments->Tags->find('list', ['limit' => 200]);
        $this->set(compact('timelineSegment', 'parentTimelineSegments', 'users', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Timeline Segment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
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
        $parentTimelineSegments = $this->TimelineSegments->ParentTimelineSegments->find('list', ['limit' => 200]);
        $users = $this->TimelineSegments->Users->find('list', ['limit' => 200]);
        $tags = $this->TimelineSegments->Tags->find('list', ['limit' => 200]);
        $this->set(compact('timelineSegment', 'parentTimelineSegments', 'users', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Timeline Segment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
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
}
