<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Entity\CampaignUser;
use App\Model\Table\CampaignsTable;
use App\Model\Entity\Campaign;
use App\Model\Table\UsersTable;
use Cake\Http\Exception\BadRequestException;
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
            throw new NotFoundException("Campaign $id not found");
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
        /** @var Campaign $campaign */
        $campaign = $this->Campaigns->newEmptyEntity();
        $data['users'] = [
            [
                'id'        => $this->user['id'],
                '_joinData' => [
                    'user_id'       => $this->user['id'],
                    'member_status' => CampaignUser::MEMBER_STATUS_ACTIVE,
                    'account_level' => CampaignUser::ACCOUNT_LEVEL_CREATOR,
                ],
            ],
        ];
        $this->isAuthorized($campaign);
        $campaign->setAccess(UsersTable::TABLE_NAME, true);
        $campaign = $this->Campaigns->patchEntity(
            $campaign,
            $data
        );

        if ($this->Campaigns->save($campaign)) {
            $this->set(compact('campaign'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse($this->response);
        } elseif ($campaign->getErrors()) {
            throw new BadRequestException();
        }
    }

    public function edit(int $id): void
    {
        $campaign = $this->Campaigns->get($id, contain: 'Users');
        $data = $this->request->getData();

        $this->isAuthorized($campaign);
        $campaign = $this->Campaigns->patchEntity($campaign, $data);

        if ($this->Campaigns->save($campaign)) {
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse($this->response);
        } else {
            throw new NotFoundException("Campaign $id not found");
        }
    }

    public function delete(int $id): void
    {
        $campaign = $this->Campaigns->get($id, contain: 'Users');
        $this->isAuthorized($campaign);
        if ($this->Campaigns->delete($campaign)) {
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse($this->response);
        } else {
            throw new NotFoundException("Campaign $id not found");
        }
    }
}
