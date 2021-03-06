<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;
use App\Model\Entity\TimelineSegment as TimelineSegmentEntity;
use App\Model\Table\TimelineSegmentsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;
use Cake\Http\Response;
use Exception;

/**
 * TimelineSegments Controller
 *
 * @property TimelineSegmentsTable $TimelineSegments
 *
 * @method TimelineSegmentEntity[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class TimelineSegmentsController extends AppController
{
    const CONTROLLER_NAME = 'Timeline Segments';
    /** @var Session */
    private $session;

    /**
     * Initialises the class, including authentication
     *
     * @return void
     * @throws Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');

        $this->session = $this->getRequest()->getSession();
    }

    /**
     * Index method
     *
     * @param int|null $campaignId The ID for the campaign that the timeline segments
     *                 should belong to
     *
     * @return Response|void
     */
    public function index(?int $campaignId): void
    {
        $this->session->write(
            'referer',
            [
                'controller' => 'TimelineSegments',
                'action'     => 'view',
                isset($id) ?: null,
            ]
        );

        $this->paginate = [
            'contain' => ['ParentTimelineSegments', 'Users'],
        ];

        $user = $this->getUserOrRedirect();

        $timelineSegments = $this->TimelineSegments
            ->find()
            ->where(['TimelineSegments.campaign_id =' => $campaignId])
            ->where(['TimelineSegments.parent_id IS' => null])
            ->where(['TimelineSegments.user_id =' => $user['id']])
            ->order('TimelineSegments.lft asc');

        $timelineSegments = $this->paginate($timelineSegments);

        $this->set('childTimelineSegments', $timelineSegments);
        $this->set('title', self::CONTROLLER_NAME);
    }

    /**
     * View method
     *
     * @param int|null $campaignId
     * @param int      $id Timeline Segment id.
     *
     * @return Response|void
     */
    public function view(int $campaignId = null, int $id = null)
    {
        $this->session->write(
            'referer',
            [
                'controller' => 'TimelineSegments',
                'action'     => (isset($id) && !is_null($id) ? 'view' : 'index'),
                isset($id) && !is_null($id) ? $id : null,
            ]
        );

        $timelineSegment = $this->TimelineSegments->get(
            $id,
            [
                'contain' => [
                    'ParentTimelineSegments',
                    'Users',
                    'Tags'                  => [
                        'sort' => ['title' => 'ASC',],
                    ],
                    'NonPlayableCharacters' => [
                        'sort' => ['name' => 'ASC',],
                    ],
                    'ChildTimelineSegments' => [
                        'sort' => ['lft' => 'ASC',],
                    ],
                ],
            ]
        );

        $this->set('breadcrumbs', $this->TimelineSegments->find('path', ['for' => $id ?: 0]));
        $this->set('timelineSegment', $timelineSegment);
        $this->set('childTimelineParts', $this->getChildTimelineParts($timelineSegment));
        $this->set(
            'title',
            sprintf(
                'View %s - %s',
                self::CONTROLLER_NAME,
                $timelineSegment->title
            )
        );
    }

    /**
     * Add method
     *
     * @param int|null $campaignId
     * @param int||string|null $parentId
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(?int $campaignId = null, $parentId = null)
    {
        $timelineSegment = $this->TimelineSegments->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if ($data['parent_id']) {
                $data['campaign_id'] = $this->TimelineSegments
                    ->findById($data['parent_id'])
                    ->firstOrFail()
                    ->campaign_id;
            } elseif ($campaignId) {
                $data['campaign_id'] = $campaignId;
            } else {
                throw new BadRequestException('Please provide the ID for a campaign.');
            }

            $timelineSegment = $this->TimelineSegments->patchEntity($timelineSegment, $data);
            // Set the user ID on the item
            $timelineSegment->user_id = $this->Auth->user('id');

            if ($this->TimelineSegments->save($timelineSegment)) {
                $this->Flash->success(__('The timeline segment, {0}, has been saved.', $timelineSegment->title));

                return $this->generateReturnUrl(
                    $timelineSegment->campaign_id,
                    $timelineSegment->parent_id
                );
            }
            $this->Flash->error(__('The timeline segment could not be saved. Please, try again.'));
        }

        $parentTimelineSegments = $this->TimelineSegments->ParentTimelineSegments->find(
            'treeList',
            [
                'limit'  => 200,
                'spacer' => '↳ ',
            ]
        );
        $users                  = $this->TimelineSegments->Users->find('list', ['limit' => 200]);
        $tags                   = $this->TimelineSegments->Tags->find(
            'list',
            [
                'limit' => 200,
                'order' => ['Tags.title' => 'ASC'],
                // TODO: it appears as though the ordering is being ignored, need to look into this
            ]
        );
        $nonPlayableCharacters  = $this->TimelineSegments->NonPlayableCharacters->find(
            'list',
            [
                'limit' => 200,
                'order' => ['NonPlayableCharacters.name' => 'ASC'],
                // TODO: it appears as though the ordering is being ignored, need to look into this
            ]
        );

        $this->set(
            compact(
                'timelineSegment',
                'parentTimelineSegments',
                'users',
                'tags',
                'nonPlayableCharacters'
            )
        );
        $this->set(
            'title',
            sprintf(
                'Add %s - %s',
                self::CONTROLLER_NAME,
                $timelineSegment->title
            )
        );
    }

    /**
     * Edit method
     *
     * @param int $campaignId
     * @param int $id Timeline Segment id.
     *
     * @return Response|void Redirects on successful edit, renders view otherwise.
     */
    public function edit(int $campaignId, ?int $id = null)
    {
        $timelineSegment = $this->TimelineSegments->get(
            $id,
            [
                'contain' => [
                    'ParentTimelineSegments',
                    'Users',
                    'Tags'                  => [
                        'sort' => ['title' => 'ASC',],
                    ],
                    'NonPlayableCharacters' => [
                        'sort' => ['name' => 'ASC',],
                    ],
                    'ChildTimelineSegments' => [
                        'sort' => ['lft' => 'ASC',],
                    ],
                ],
            ]
        );

        if ($this->request->is(['patch', 'post', 'put'])) {
            $timelineSegment = $this->TimelineSegments->patchEntity($timelineSegment, $this->request->getData());
            if ($this->TimelineSegments->save($timelineSegment)) {
                $this->Flash->success(__('The timeline segment, {0}, has been saved.', $timelineSegment->title));

                return $this->generateReturnUrl(
                    $timelineSegment->campaign_id,
                    $timelineSegment->parent_id
                );
            }
            $this->Flash->error(__('The timeline segment could not be saved. Please, try again.'));
        }
        $parentTimelineSegments = $this->TimelineSegments->ParentTimelineSegments->find(
            'treeList',
            [
                'limit'  => 200,
                'spacer' => '↳ ',
            ]
        );
        $users                  = $this->TimelineSegments->Users->find('list', ['limit' => 200]);
        $tags                   = $this->TimelineSegments->Tags->find(
            'list',
            [
                'limit' => 200,
                'order' => ['title' => 'ASC'],
                // TODO: it appears as though the ordering is being ignored, need to look into this
            ]
        );
        $nonPlayableCharacters  = $this->TimelineSegments->NonPlayableCharacters->find(
            'list',
            [
                'limit' => 200,
                'order' => ['name' => 'ASC'],
                // TODO: it appears as though the ordering is being ignored, need to look into this
            ]
        );

        $this->set('breadcrumbs', $this->TimelineSegments->find('path', ['for' => $id ?: 0]));
        $this->set(
            compact(
                'timelineSegment',
                'parentTimelineSegments',
                'users',
                'tags',
                'nonPlayableCharacters'
            )
        );
        $this->set('childTimelineParts', $this->getChildTimelineParts($timelineSegment));
        $this->set(
            'title',
            sprintf(
                'Edit %s - %s',
                self::CONTROLLER_NAME,
                $timelineSegment->title
            )
        );
    }

    /**
     * Delete method
     *
     * @param int $id Timeline Segment id.
     *
     * @return Response Redirects to index or to the view for the parent.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete(int $id = null): Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $timelineSegment = $this->TimelineSegments->get($id);

//        $url = $this->generateReturnUrl($timelineSegment);

        $campaignId = $timelineSegment->campaign_id;
        $parentId   = $timelineSegment->parent_id;

        if ($this->TimelineSegments->delete($timelineSegment)) {
            $this->Flash->success(__('The timeline segment, {0}, has been deleted.', $timelineSegment->title));
        } else {
            $this->Flash->error(__('The timeline segment could not be deleted. Please, try again.'));
        }

        if ($parentId) {
            return $this->generateReturnUrl($campaignId, $parentId);
        }

        return $this->redirect(
            [
                '_name'      => 'TimelineSegments',
                'campaignId' => $campaignId,
            ]
        );
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
                'tags',
                'getTags',
                'getNonPlayableCharacters',
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
        $timelineSegment = $this->TimelineSegments->findById($id)->firstOrFail();

        return $timelineSegment->user_id === $user['id'];
    }

    /**
     * Generates the URL for returning the user after saving
     *
     * @param int      $campaignId
     * @param int|null $parentId
     *
     * @return Response
     */
    private function generateReturnUrl(int $campaignId, ?int $parentId): Response
    {
        $urlParams = [
            '_name'      => 'TimelineSegments',
            'campaignId' => $campaignId,
        ];

        if ($parentId) {
            $urlParams['_name']  = 'TimelineSegmentsId';
            $urlParams['action'] = 'view';
            $urlParams['id']     = $parentId;
        } else {
            $urlParams['action'] = 'index';
        }

        return $this->redirect(Router::url($urlParams));
    }

    /**
     * Moves an item up or to the top
     *
     * @param int      $id ID of the item to move up
     * @param bool|int $top Determines if the item to should moved to top - defaults to 1, as the integer
     *                       is used for how many places to move the node by
     *
     * @return
     */
    public function moveUp(int $campaignId, int $id, $top = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        $timelineSegment = $this->TimelineSegments->get($id);
        if ($this->TimelineSegments->moveUp($timelineSegment, $top)) {
            $this->Flash->success('The timeline segment has been moved up.');
        } else {
            $this->Flash->error('The timeline segment could not be moved up. Please, try again.');
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Moves the item to the top - wraps around moveUp()
     *
     * @param int $id ID of item to move to bottom
     *
     * @return
     */
    public function moveUpTop(int $campaignId, int $id)
    {
        return $this->moveUp($campaignId, $id, true);
    }

    /**
     * Moves an item down or to the bottom
     *
     * @param int      $id ID of the item to move down
     * @param bool|int $bottom Determines if the item to should moved to bottom - defaults to 1, as the integer
     *                          is used for how many places to move the node by
     *
     * @return
     */
    public function moveDown(int $campaignId, int $id, $bottom = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        $timelineSegment = $this->TimelineSegments->get($id);
        if ($this->TimelineSegments->moveDown($timelineSegment, $bottom)) {
            $this->Flash->success('The timeline segment has been moved down.');
        } else {
            $this->Flash->error('The timeline segment could not be moved down. Please, try again.');
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Moves the item to the bottom - wraps around moveDown()
     *
     * @param int $id ID of item to move to bottom
     *
     * @return
     */
    public function moveDownBottom(int $campaignId, int $id)
    {
        return $this->moveDown($campaignId, $id, true);
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

        echo $this->formatJsonResponse(
            $this->TimelineSegments->Tags,
            $term,
            ['Tags.title LIKE' => '%' . $term . '%'],
            'title',
            'title'
        );
    }

    /**
     * Looks up tags based on a wildcard search term,
     * starting with at least three character
     *
     * @return string
     */
    public function getNonPlayableCharacters()
    {
        $this->autoRender = false;

        $term = $this->request->getQuery('term');

        echo $this->formatJsonResponse(
            $this->TimelineSegments->NonPlayableCharacters,
            $term,
            ['NonPlayableCharacters.name LIKE' => '%' . $term . '%'],
            'name',
            'name'
        );
    }

    /**
     * Uses a regular expression to extract any content that is within a <blockquote> element
     *
     * @param TimeLineSegment $timeline The timeline segment object
     *
     * @return string
     */
    private function getChildTimelineParts(TimelineSegmentEntity $timelineSegment): string
    {
        $content            = '';
        $timelinePartsArray = [];
        $timelineParts      = '';

        if ($timelineSegment->child_timeline_segments) {
            // echo '<pre>';
            /** @var TimelineSegment $childTimeline */
            foreach ($timelineSegment->child_timeline_segments as $childTimeline) {
                // var_dump($childTimeline->body);
                preg_match_all(
                    '/\{\{blockquote\}\}(\{\{p\}\})?(.*?)(\{\{\/p\}\})?\{\{\/blockquote\}\}/i',
                    $childTimeline->body,
                    $out
                );
                // if (!empty($out[2])) {
                //     // var_dump($out,'-----------------------------------');
                //     $timelinePartsArray[] = implode(' | ', $out[2]);
                // }

                if (!empty($out[2])) {
                    $timelinePartsArray[] = sprintf(
                        '<h3>%s</h3><ul><li>%s</li></ul>',
                        $childTimeline->title,
                        implode('</li><li>', $out[2])
                    );
                }
            }

            // var_dump($timelineSegment);exit();
            // } else {
            // $content = dbConverter::fromDatabase($this->Text->autoParagraph($timelineSegment->body));
        }

        return implode('', $timelinePartsArray);
    }
}
