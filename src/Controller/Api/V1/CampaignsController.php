<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Table\CampaignsTable;
use App\Model\Entity\Campaign;
use App\Model\Entity\CampaignPermission;
use App\Model\Table\UsersTable;
use App\Error\Api\BadRequestError;
use App\Error\Api\NotFoundError;
use App\Error\Api\UnauthorizedError;
use App\Model\Entity\Role;
use App\Model\Enum\DefaultRoleLevel;
use App\Model\Table\CampaignPermissionsTable;
use App\Model\Table\RolesTable;

/**
 * Campaigns Controller
 *
 * @property CampaignsTable $Campaigns
 */
class CampaignsController extends ApiAppController
{
    public function view(int $id): void
    {
        $campaign = $this->Campaigns->findByIdWithUsers(id: $id);

        if ($campaign === null) {
            throw new NotFoundError(message: "Campaign $id not found");
        }

        $this->isAuthorized(entity: $campaign);

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
            throw new UnauthorizedError();
        }

        $campaigns = $this->Campaigns->findAllByUserId(userId: $user['id']);

        $this->set(compact('campaigns'));
    }

    public function add(): void
    {
        $data = $this->request->getData();
        $data['user_id'] = $this->user['id'];

        /** @var Campaign $campaign */
        $campaign = $this->Campaigns->newEmptyEntity();

        $this->isAuthorized(entity: $campaign);

        $campaign->setAccess(field: UsersTable::TABLE_NAME, set: true);
        $campaign = $this->Campaigns->patchEntity(
            entity: $campaign,
            data: $data
        );

        if ($this->Campaigns->save(entity: $campaign)) {
            $this->addDefaultRolesAndPermissions(campaign: $campaign);

            $this->set(compact('campaign'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse(response: $this->response);
        } elseif ($campaign->getErrors()) {
            throw new BadRequestError(errors: $campaign->getErrors());
        }
    }

    private function addDefaultRolesAndPermissions(Campaign $campaign): void
    {
        $rolesTable = $this->fetchTable(RolesTable::class);
        $creatorRole = $this->addRole(rolesTable: $rolesTable, campaign: $campaign, roleLevel: DefaultRoleLevel::Creator);
        $this->addRole(rolesTable: $rolesTable, campaign: $campaign, roleLevel: DefaultRoleLevel::Admin);
        $this->addRole(rolesTable: $rolesTable, campaign: $campaign, roleLevel: DefaultRoleLevel::User);

        // Link the user to the newly created "Creator" role for this campaign
        $rolesTable->Users->link($creatorRole, [$this->user]);

        $this->addCreatorCampaignPermissionForUser(campaign: $campaign, creatorRole: $creatorRole);
    }

    private function addRole(RolesTable $rolesTable, Campaign $campaign, DefaultRoleLevel $roleLevel): Role
    {
        /** @var Role $role */
        $role = $rolesTable->newEmptyEntity();
        $role = $rolesTable->patchEntity(
            entity: $role,
            data: [
                Role::FIELD_ROLE_NAME => $roleLevel->label(),
                Role::FIELD_CAMPAIGN_ID => $campaign->id,
            ]
        );

        if (!$rolesTable->save(entity: $role)) {
            throw new BadRequestError(errors: $role->getErrors());
        }

        return $role;
    }

    private function addCreatorCampaignPermissionForUser(Campaign $campaign, Role $creatorRole): void
    {
        $campaignPermissionsTable = $this->fetchTable(CampaignPermissionsTable::class);
        /** @var CampaignPermission $campaignPermissions */
        $campaignPermission = $campaignPermissionsTable->newEmptyEntity();
        $campaignPermissionsTable->patchEntity(
            entity: $campaignPermission,
            data: [
                CampaignPermission::FIELD_CAMPAIGN_ID => $campaign->id,
                CampaignPermission::FIELD_ROLE_ID => $creatorRole->getId(),
                CampaignPermission::FIELD_CAN_READ => true,
                CampaignPermission::FIELD_CAN_WRITE => true,
                CampaignPermission::FIELD_CAN_DELETE => true,
                CampaignPermission::FIELD_CAN_PERMISSION => true,
            ],
        );

        if (!$campaignPermissionsTable->save(entity: $campaignPermission)) {
            throw new BadRequestError(errors: $campaignPermission->getErrors());
        }
    }

    public function edit(int $id): void
    {
        $campaign = $this->Campaigns->get(primaryKey: $id, contain: 'Users');
        $data = $this->request->getData();

        $this->isAuthorized(entity: $campaign);
        $campaign = $this->Campaigns->patchEntity(entity: $campaign, data: $data);

        if ($this->Campaigns->save(entity: $campaign)) {
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new NotFoundError(message: "Campaign $id not found");
        }
    }

    public function delete(int $id): void
    {
        $campaign = $this->Campaigns->get(primaryKey: $id, contain: 'Users');
        $this->isAuthorized(entity: $campaign);
        if ($this->Campaigns->delete(entity: $campaign)) {
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new NotFoundError(message: "Campaign $id not found");
        }
    }
}
