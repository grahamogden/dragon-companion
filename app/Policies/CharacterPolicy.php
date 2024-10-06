<?php

namespace App\Policies;

use App\Enums\RolePermissionEnum;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CharacterPolicy
{
    use UserRolePermissionPolicyTrait;
    use UserOwnsCampaignTrait;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Character $item, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasCharacterPermission(permission: RolePermissionEnum::Read)
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasCharacterPermission(permission: RolePermissionEnum::Write)
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Character $item, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasCharacterPermission(permission: RolePermissionEnum::Write)
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Character $item, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasCharacterPermission(permission: RolePermissionEnum::Delete)
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Character $item): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Character $item): bool
    {
        return false;
    }
}
