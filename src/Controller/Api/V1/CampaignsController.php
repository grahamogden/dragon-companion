<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Table\CampaignsTable;
use App\Model\Entity\Campaign;
use App\Model\Entity\CampaignPermission;
use App\Model\Table\UsersTable;
use App\Error\Api\BadRequestError;
use App\Error\Api\NotFoundError;
use App\Model\Entity\Role;
use App\Model\Entity\User;
use App\Model\Enum\EntityVisibility;
use App\Model\Enum\RoleLevel;
use App\Model\Enum\RolePermission;
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
        $campaign = $this->Campaigns->findOneByIdWithUsers(id: $id);

        if ($campaign === null) {
            throw new NotFoundError(message: "Campaign $id not found");
        }

        $this->isAuthorized(entity: $campaign);

        $this->output(compact('campaign'));
    }

    public function index(): void
    {
        $campaigns = $this->Campaigns->findByUserIdWithPermissionsCheck(identity: $this->user);

        // Skip the authorization because it happens when we get the entities from the DB
        $this->Authorization->skipAuthorization();

        $this->output(['campaigns' => $campaigns]);
    }

    public function add(): void
    {
        $data = $this->request->getData();
        $data['user_id'] = $this->user['id'];

        /** @var Campaign $campaign */
        $campaign = $this->Campaigns->newEntity(data: $data, options: ['accessibleFields' => [UsersTable::TABLE_NAME => true]]);

        $campaign->setAccess(field: UsersTable::TABLE_NAME, set: true);

        $this->isAuthorized(entity: $campaign);

        if ($this->Campaigns->save(entity: $campaign)) {
            $this->addDefaultRolesAndPermissions(campaign: $campaign);

            $this->output(compact('campaign'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse(response: $this->response);
        } elseif ($campaign->getErrors()) {
            throw new BadRequestError(message: 'Error adding Campaign', errors: $campaign->getErrors());
        }
    }

    private function addDefaultRolesAndPermissions(Campaign $campaign): void
    {
        $rolesTable = $this->fetchTable(RolesTable::class);
        $creatorRole = $this->addRole(
            rolesTable: $rolesTable,
            campaign: $campaign,
            roleLevel: RoleLevel::Owner,
            roleName: RoleLevel::Owner->label(),
            campaignDefaultPermissions: RolePermission::Read_write_delete,
            speciesDefaultPermissions: RolePermission::Read_write_delete,
        );
        $this->addRole(
            rolesTable: $rolesTable,
            campaign: $campaign,
            roleLevel: RoleLevel::Admin,
            roleName: RoleLevel::Admin->label(),
            campaignDefaultPermissions: RolePermission::Read_write_delete,
            speciesDefaultPermissions: RolePermission::Read_write_delete,
        );
        $this->addRole(
            rolesTable: $rolesTable,
            campaign: $campaign,
            roleLevel: RoleLevel::Custom,
            roleName: 'Default',
            campaignDefaultPermissions: RolePermission::Read,
            speciesDefaultPermissions: RolePermission::Read,
        );

        // Link the user to the newly created "Creator" role for this campaign
        $rolesTable->Users->link($creatorRole, [$this->user]);

        // $this->addCreatorCampaignPermissionForUser(campaign: $campaign, creatorRole: $creatorRole);
    }

    private function addRole(
        RolesTable $rolesTable,
        Campaign $campaign,
        RoleLevel $roleLevel,
        string $roleName,
        RolePermission $campaignDefaultPermissions,
        RolePermission $speciesDefaultPermissions,
    ): Role {
        /** @var Role $role */
        $role = $rolesTable->newEmptyEntity();
        $role = $rolesTable->patchEntity(
            entity: $role,
            data: [
                Role::FIELD_ROLE_LEVEL => $roleLevel->value,
                Role::FIELD_ROLE_NAME => $roleName,
                Role::FIELD_CAMPAIGN_ID => $campaign->id,
                Role::FIELD_CAMPAIGN_DEFAULT_PERMISSIONS => $campaignDefaultPermissions->value,
                Role::FIELD_SPECIES_DEFAULT_PERMISSIONS => $speciesDefaultPermissions->value,
            ],
        );

        if (!$rolesTable->save(entity: $role)) {
            throw new BadRequestError(message: 'Error creating Roles for Campaign', errors: $role->getErrors());
        }

        return $role;
    }

    // private function addCreatorCampaignPermissionForUser(Campaign $campaign, Role $creatorRole): void
    // {
    //     $campaignPermissionsTable = $this->fetchTable(CampaignPermissionsTable::class);
    //     /** @var CampaignPermission $campaignPermissions */
    //     $campaignPermission = $campaignPermissionsTable->newEmptyEntity();
    //     $campaignPermissionsTable->patchEntity(
    //         entity: $campaignPermission,
    //         data: [
    //             CampaignPermission::FIELD_CAMPAIGN_ID => $campaign->id,
    //             CampaignPermission::FIELD_ROLE_ID => $creatorRole->getId(),
    //             // CampaignPermission::FIELD_CAN_READ => true,
    //             // CampaignPermission::FIELD_CAN_WRITE => true,
    //             // CampaignPermission::FIELD_CAN_DELETE => true,
    //             // CampaignPermission::FIELD_CAN_PERMISSION => true,
    //             CampaignPermission::FIELD_PERMISSIONS => RolePermission::
    //         ],
    //     );

    //     if (!$campaignPermissionsTable->save(entity: $campaignPermission)) {
    //         throw new BadRequestError(errors: $campaignPermission->getErrors());
    //     }
    // }

    public function edit(int $id): void
    {
        $campaign = $this->Campaigns->get(primaryKey: $id, contain: [User::ENTITY_NAME, CampaignPermission::ENTITY_NAME]);

        if ($campaign === null) {
            throw new NotFoundError(message: "Campaign $id not found");
        }

        $data = $this->request->getData();

        $this->isAuthorized(entity: $campaign);

        $campaign = $this->Campaigns->patchEntity(entity: $campaign, data: $data);

        if ($this->Campaigns->save(entity: $campaign)) {
            $this->output(compact('campaign'));
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error saving Campaign: $id", errors: $campaign->getErrors());
        }
    }

    public function delete(int $id): void
    {
        $campaign = $this->Campaigns->get(primaryKey: $id, contain: [User::ENTITY_NAME, CampaignPermission::ENTITY_NAME]);

        if ($campaign === null) {
            throw new NotFoundError(message: "Campaign $id not found");
        }

        $this->isAuthorized(entity: $campaign);

        if ($this->Campaigns->delete(entity: $campaign)) {
            $this->output([]);
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error deleting Campaign: $id", errors: $campaign->getErrors());
        }
    }
}
