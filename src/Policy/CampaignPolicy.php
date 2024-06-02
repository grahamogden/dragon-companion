<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Campaign;
use App\Model\Entity\CampaignPermission;
use App\Model\Entity\Role;
use App\Model\Entity\User;
use Authentication\IdentityInterface;

/**
 * Campaign policy
 */
class CampaignPolicy
{
    public function canAdd(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        return !!$identity->getIdentifier();
    }

    public function canEdit(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        if ($this->isCreator(identity: $identity, campaign: $campaign)) {
            return true;
        }

        $userRole = $this->getUserRoleForCampaign(identity: $identity, campaign: $campaign);

        if (null === $userRole) {
            return false;
        }

        /** @var CampaignPermission $permission */
        foreach ($campaign->campaign_permissions as $permissions) {
            if ($permissions->getRoleId() === $userRole->getId()) {
                return $permission->canWrite();
            }
        }
        return false;
    }

    public function canDelete(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        if ($this->isCreator(identity: $identity, campaign: $campaign)) {
            return true;
        }

        $userRole = $this->getUserRoleForCampaign(identity: $identity, campaign: $campaign);

        if (null === $userRole) {
            return false;
        }

        /** @var CampaignPermission $permission */
        foreach ($campaign->campaign_permissions as $permissions) {
            if ($permissions->getRoleId() === $userRole->getId()) {
                return $permission->canDelete();
            }
        }
        return false;
    }

    public function canView(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        if ($this->isCreator(identity: $identity, campaign: $campaign)) {
            return true;
        }

        $userRole = $this->getUserRoleForCampaign(identity: $identity, campaign: $campaign);

        if (null === $userRole) {
            return false;
        }

        /** @var CampaignPermission $permission */
        foreach ($campaign->campaign_permissions as $permissions) {
            if ($permissions->getRoleId() === $userRole->getId()) {
                return $permission->canRead();
            }
        }
        return false;
    }

    private function getUserRoleForCampaign(IdentityInterface|User $identity, Campaign $campaign): ?Role
    {
        foreach ($identity->getRoles() as $role) {
            if ($role->campaign_id === $campaign->id) {
                return $role;
            }
        }

        return null;
    }

    private function isCreator(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        return $campaign->user_id === $identity->getIdentifier();
    }
}
