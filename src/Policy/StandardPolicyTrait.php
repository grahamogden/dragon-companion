<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Interface\CampaignChildEntityInterface;
use App\Model\Entity\Interface\EntityInterfaceWithUserIdInterface;
use App\Model\Entity\Interface\PermissionInterface;
use App\Model\Entity\Role;
use App\Model\Entity\User;
use App\Model\Enum\RoleLevel;
use App\Model\Enum\RolePermission;
use Authentication\IdentityInterface;
use Cake\Datasource\EntityInterface;
use RuntimeException;

trait StandardPolicyTrait
{
    private function getOverridePermissionsTableName(): string
    {
        if (isset($this->overridePermissionsTableName)) {
            return $this->overridePermissionsTableName;
        }

        throw new RuntimeException('overridePermissionsTableName was not set on policy');
    }

    private function getDefaultPermissionsFieldName(): string
    {
        if (isset($this->defaultPermissionsFieldName)) {
            return $this->defaultPermissionsFieldName;
        }

        throw new RuntimeException('defaultPermissionsFieldName was not set on policy');
    }

    private function getUserRoleForCampaign(IdentityInterface|User $identity, int $campaignId): ?Role
    {
        if (!$identity->getIdentifier()) {
            return null;
        }

        foreach ($identity->getRoles() as $role) {
            if ($role->getCampaignId() === $campaignId) {
                return $role;
            }
        }

        return null;
    }

    private function isCreatorOfEntity(IdentityInterface|User $identity, EntityInterfaceWithUserIdInterface $entity): bool
    {
        return $entity->getUserId() === $identity->getIdentifier();
    }

    private function isCampaignOwner(IdentityInterface|User $identity, int $campaignId): bool
    {
        return $this->getUserRoleForCampaign(
            identity: $identity,
            campaignId: $campaignId
        )?->getRoleLevel() === RoleLevel::Owner;
    }

    private function getDefaultUserRolePermission(Role $userRole): RolePermission
    {
        return $userRole->{$this->getDefaultPermissionsFieldName()}();
    }

    private function getOverrideEntityRolePermissionForUser(Role $userRole, EntityInterface $entity): RolePermission
    {
        $entityPermissions = $entity->{$this->getOverridePermissionsTableName()}();

        /** @var PermissionInterface $entityPermission */
        foreach ($entityPermissions as $entityPermission) {
            if ($entityPermission->getRoleId() === $userRole->getId()) {
                return $entityPermission->getPermissions();
            }
        }
        return RolePermission::Inherit;
    }

    public function canAdd(IdentityInterface|User $identity, CampaignChildEntityInterface&EntityInterfaceWithUserIdInterface $entity): bool
    {
        $userRole = $this->getUserRoleForCampaign(
            identity: $identity,
            campaignId: $entity->getCampaignId(),
        );

        if (null === $userRole) {
            return false;
        }

        // If the user is the owner of the campaign, then allow them to do anything
        if ($userRole->getRoleLevel() === RoleLevel::Owner) {
            return true;
        }

        $userHasDefaultPermissionToAddEntity = is_callable([$userRole, $this->getDefaultPermissionsFieldName()])
            && RolePermission::hasWritePermission(
                $this->getDefaultUserRolePermission($userRole)
            );

        // Do not check for override permissions for adding entites because the override will not exist yet

        if ($userHasDefaultPermissionToAddEntity) {
            return true;
        }

        return false;
    }

    private function canWriteForCampaignId(
        IdentityInterface|User $identity,
        int $campaignId,
        EntityInterfaceWithUserIdInterface $entity
    ): bool {
        if ($this->isCreatorOfEntity(identity: $identity, entity: $entity)) {
            return true;
        }

        $userRole = $this->getUserRoleForCampaign(
            identity: $identity,
            campaignId: $campaignId,
        );

        if (null === $userRole) {
            return false;
        }

        // If the user is the owner of the campaign, then allow them to do anything
        if ($userRole->getRoleLevel() === RoleLevel::Owner) {
            return true;
        }

        // if ($this->isCampaignOwner(
        //     identity: $identity,
        //     campaignId: $campaignId,
        // )) {
        //     return true;
        // }

        $overrideEntityPermission = $this->getOverrideEntityRolePermissionForUser(userRole: $userRole, entity: $entity);

        if ($overrideEntityPermission !== RolePermission::Inherit) {
            return RolePermission::hasWritePermission($overrideEntityPermission);
        }

        $userHasPermissionToUpdateEntity = is_callable([$userRole, $this->getDefaultPermissionsFieldName()])
            && RolePermission::hasWritePermission(
                $this->getDefaultUserRolePermission($userRole)
            );

        if ($userHasPermissionToUpdateEntity) {
            return true;
        }

        return false;
    }

    public function canEdit(IdentityInterface|User $identity, CampaignChildEntityInterface&EntityInterfaceWithUserIdInterface $entity): bool
    {
        return $this->canWriteForCampaignId(
            identity: $identity,
            campaignId: $entity->getCampaignId(),
            entity: $entity,
        );
    }

    private function canReadForCampaignId(
        IdentityInterface|User $identity,
        int $campaignId,
        EntityInterfaceWithUserIdInterface $entity
    ): bool {
        if ($this->isCreatorOfEntity(identity: $identity, entity: $entity)) {
            return true;
        }

        $userRole = $this->getUserRoleForCampaign(
            identity: $identity,
            campaignId: $campaignId
        );

        if (null === $userRole) {
            return false;
        }

        // If the user is the owner of the campaign, then allow them to do anything
        if ($userRole->getRoleLevel() === RoleLevel::Owner) {
            return true;
        }

        // if ($this->isCampaignOwner(
        //     identity: $identity,
        //     campaignId: $campaignId,
        // )) {
        //     return true;
        // }

        $overrideEntityPermission = $this->getOverrideEntityRolePermissionForUser(userRole: $userRole, entity: $entity);

        if ($overrideEntityPermission !== RolePermission::Inherit) {
            return RolePermission::hasReadPermission($overrideEntityPermission);
        }

        $userHasPermissionToReadEntity = is_callable([$userRole, $this->getDefaultPermissionsFieldName()])
            && RolePermission::hasReadPermission(
                $this->getDefaultUserRolePermission($userRole)
            );

        if ($userHasPermissionToReadEntity) {
            return true;
        }

        return false;
    }

    public function canView(
        IdentityInterface|User $identity,
        CampaignChildEntityInterface&EntityInterfaceWithUserIdInterface $entity
    ): bool {
        return $this->canReadForCampaignId(
            identity: $identity,
            campaignId: $entity->getCampaignId(),
            entity: $entity
        );
    }

    public function canIndex(IdentityInterface|User $identity, CampaignChildEntityInterface&EntityInterfaceWithUserIdInterface $entity): bool
    {
        return $this->canReadForCampaignId(
            identity: $identity,
            campaignId: $entity->getCampaignId(),
            entity: $entity
        );
    }

    private function canDeleteForCampaignId(
        IdentityInterface|User $identity,
        int $campaignId,
        EntityInterfaceWithUserIdInterface $entity
    ): bool {
        if ($this->isCreatorOfEntity(identity: $identity, entity: $entity)) {
            return true;
        }

        $userRole = $this->getUserRoleForCampaign(
            identity: $identity,
            campaignId: $campaignId
        );

        if (null === $userRole) {
            return false;
        }

        // If the user is the owner of the campaign, then allow them to do anything
        if ($userRole->getRoleLevel() === RoleLevel::Owner) {
            return true;
        }

        // if ($this->isCampaignOwner(
        //     identity: $identity,
        //     campaignId: $campaignId,
        // )) {
        //     return true;
        // }

        $overrideEntityPermission = $this->getOverrideEntityRolePermissionForUser(userRole: $userRole, entity: $entity);

        if ($overrideEntityPermission !== RolePermission::Inherit) {
            return RolePermission::hasDeletePermission($overrideEntityPermission);
        }

        $userHasPermissionToDeleteEntity = is_callable([$userRole, $this->getDefaultPermissionsFieldName()])
            && RolePermission::hasDeletePermission(
                $this->getDefaultUserRolePermission($userRole)
            );

        if ($userHasPermissionToDeleteEntity) {
            return true;
        }

        return false;
    }

    public function canDelete(IdentityInterface|User $identity, CampaignChildEntityInterface&EntityInterfaceWithUserIdInterface $entity): bool
    {
        return $this->canDeleteForCampaignId(
            identity: $identity,
            campaignId: $entity->getCampaignId(),
            entity: $entity,
        );
    }
}
