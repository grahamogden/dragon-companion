<?php

namespace App\Policies;

use App\Enums\RolePermissionEnum;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CampaignPolicy
{
    public const MAX_CAMPAIGN_COUNT = 3;

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
    public function view(User $user, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasCampaignPermission(permission: RolePermissionEnum::Read)
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if (((bool) $user->id) === false) {
            return Response::deny();
        }

        if ((bool) $user->id) {
            return $user->campaigns()->count() < self::MAX_CAMPAIGN_COUNT
                ? Response::allow()
                : Response::deny(message: 'You have reached the maximum limit for the number of campaigns you can have (3). Please consider subscribing to one of the paid tiers to unlock unlimited campaigns!');
        }

        // User is not logged in, so deny
        return Response::deny();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasCampaignPermission(permission: RolePermissionEnum::Write)
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasCampaignPermission(permission: RolePermissionEnum::Delete)
            || $this->isCampaignOwner(user: $user, campaign: $campaign);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Campaign $campaign): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Campaign $campaign): bool
    {
        return false;
    }
}
