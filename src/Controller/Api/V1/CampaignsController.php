<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Entity\CampaignUser;
use App\Model\Table\CampaignsTable;
use App\Model\Entity\Campaign;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\UnauthorizedException;

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

        if ($campaign === null) {
            throw new NotFoundException('Campaign not found');
        }

        $this->isAuthorized($campaign);

        $this->set(compact('campaign'));
    }

    public function index(): void
    {
        // We can skip authorization here because we are only going to get Campaigns
        // that are actually linked to the user ID provided - so you can't sneakily
        // get someone else's
        $this->Authorization->skipAuthorization();

        $user = $this->user;

        if ($user === null) {
            throw new UnauthorizedException();
        }

        $campaigns = $this->Campaigns->findAllByUserId($user['id']);

        $this->set(compact('campaigns'));
    }

    public function add(): void
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
        $campaign->setName($data['name'])
            ->setSynopsis($data['synopsis'])
            ->setAccess('users', true);
        // $campaign->addUser($this->user['id'], CampaignUser::MEMBER_STATUS_ACTIVE, CampaignUser::ACCOUNT_LEVEL_CREATOR);
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
        }

        $this->apiResponseHeaderService->returnBadRequestResponse($this->response);
    }

    public function edit(int $id): void
    {
        $campaign = $this->Campaigns->get($id, contain: 'Users');
        $data = $this->request->getData();

        $this->isAuthorized($campaign);
        $campaign = $this->Campaigns->patchEntity($campaign, $data);

        if ($this->Campaigns->save($campaign)) {
            $this->apiResponseHeaderService->returnNoContentResponse($this->response);
        } else {
            $this->apiResponseHeaderService->returnNotFoundResponse($this->response);
        }
    }

    public function delete(int $id): void
    {
        $campaign = $this->Campaigns->get($id, contain: 'Users');
        $this->isAuthorized($campaign);
        if ($this->Campaigns->delete($campaign)) {
            $this->apiResponseHeaderService->returnNoContentResponse($this->response);
        } else {
            $this->apiResponseHeaderService->returnNotFoundResponse($this->response);
        }
    }
}
