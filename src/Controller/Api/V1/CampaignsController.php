<?php

namespace App\Controller\Api\V1;

use App\Model\Entity\CampaignUser;
use App\Model\Table\CampaignsTable;
use App\Model\Entity\Campaign;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * Campaigns Controller
 *
 * @property CampaignsTable $Campaigns
 */
class CampaignsController extends ApiAppController
{
    public function view(int $id): void
    {
        $campaign = $this->Campaigns->findByIdWithUsers($id);

        $this->isAuthorized($campaign);

        // unset($campaign->users);
        // return $this->output(['Campaign' => $campaign]);
        $this->set(compact('campaign'));
        // $this->viewBuilder()->setOption('serialize', 'campaign');
    }

    public function index(): void
    {
        $this->Authorization->skipAuthorization();
        $user = $this->user;

        $campaigns = $this->Campaigns->findAllByUserId($user['id']);

        $this->set(compact('campaigns'));
        // $this->viewBuilder()->setTemplate('index');
        $this->apiResponseHeaderService->returnBadRequestResponse($this->response);
        // return $this->response;
    }

    public function add(): Response
    {
        $data = $this->request->getData();
        // $campaign = $this->Campaigns->newEmptyEntity();
        $campaign = new Campaign();
        // $data['users'] = [
        //     [
        //         'id'        => $this->user['id'],
        //         '_joinData' => [
        //             'user_id'       => $this->user['id'],
        //             'member_status' => CampaignUser::MEMBER_STATUS_ACTIVE,
        //             'account_level' => CampaignUser::ACCOUNT_LEVEL_CREATOR,
        //         ],
        //     ],
        // ];
        $this->isAuthorized($campaign);
        $campaign->setName($data['name']);
        $campaign->setSynopsis($data['synopsis']);
        // $campaign->addUser($this->user['id'], CampaignUser::MEMBER_STATUS_ACTIVE, CampaignUser::ACCOUNT_LEVEL_CREATOR);
        $campaign->setAccess('users', true);
        $campaign = $this->Campaigns->patchEntity($campaign, [
            'users' => [
                [
                    'id'        => $this->user['id'],
                    '_joinData' => [
                        'user_id'       => $this->user['id'],
                        'member_status' => CampaignUser::MEMBER_STATUS_ACTIVE,
                        'account_level' => CampaignUser::ACCOUNT_LEVEL_CREATOR,
                    ],
                ],
            ],
        ]);

        if ($this->Campaigns->save($campaign)) {
            $this->set(compact('campaign'));
            $this->apiResponseHeaderService->returnCreatedResponse($this->response);
        } else {
            $this->apiResponseHeaderService->returnBadRequestResponse($this->response);
        }
        return $this->response;
    }

    public function edit(int $id): Response
    {
        $campaign = $this->Campaigns->get($id, contain: 'Users');
        $data            = $this->request->getData();

        $this->isAuthorized($campaign);
        $campaign = $this->Campaigns->patchEntity($campaign, $data);

        if ($this->Campaigns->save($campaign)) {
            // header('HTTP/1.0 204 No content');
            // exit;
            $this->apiResponseHeaderService->returnNoContentResponse($this->response);
        } else {
            $this->apiResponseHeaderService->returnNotFoundResponse($this->response);
            // header('HTTP/1.0 404 Not found');
            // exit;
        }

        return $this->response;
    }

    public function delete(int $id): Response
    {
        $campaign = $this->Campaigns->get($id, contain: 'Users');
        $this->isAuthorized($campaign);
        if ($this->Campaigns->delete($campaign)) {
            // header('HTTP/1.0 204 No content');
            // exit;
            $this->apiResponseHeaderService->returnNoContentResponse($this->response);
        } else {
            $this->apiResponseHeaderService->returnNotFoundResponse($this->response);
            // header('HTTP/1.0 404 Not found');
            // exit;
        }

        return $this->response;
    }

    /**
     * Determines whether the user is authorised to be able to use this action
     *
     * @return bool
     */
    public function isAuthorized($campaign): void
    {
        $this->Authorization->authorize($campaign);
    }
}
