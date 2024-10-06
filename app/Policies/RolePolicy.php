<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    public const MAX_ROLE_COUNT = 2;

    use UserRolePermissionPolicyTrait;
    use UserOwnsCampaignTrait;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRole(user: $user, campaign: $campaign)
            ->isAdminRoleLevel()
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Campaign $campaign): Response
    {
        if (((bool) $user->id) === false) {
            return Response::deny();
        }

        if ($campaign->roles()->count() >= self::MAX_ROLE_COUNT) {
            return Response::deny(
                message: sprintf('You have reached the maximum limit for the number of roles you can have (%s). Please consider subscribing to one of the paid tiers to unlock unlimited roles!', self::MAX_ROLE_COUNT)
            );
        }

        return $this->getUserRole(user: $user, campaign: $campaign)
            ->isAdminRoleLevel()
            || $this->isCampaignOwner(user: $user, campaign: $campaign)
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRole(user: $user, campaign: $campaign)
            ->isAdminRoleLevel()
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRole(user: $user, campaign: $campaign)
            ->isAdminRoleLevel()
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRole(user: $user, campaign: $campaign)
            ->isAdminRoleLevel()
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return false;
    }
}
