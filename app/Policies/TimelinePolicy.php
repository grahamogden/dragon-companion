<?php

namespace App\Policies;

use App\Enums\RolePermissionEnum;
use App\Models\Campaign;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TimelinePolicy
{
    use UserRolePermissionPolicyTrait;

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
    public function view(User $user, Timeline $timeline, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasTimelinePermission(permission: RolePermissionEnum::Read);
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
            ->hasTimelinePermission(permission: RolePermissionEnum::Write);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Timeline $timeline, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasTimelinePermission(permission: RolePermissionEnum::Write);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Timeline $timeline, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasTimelinePermission(permission: RolePermissionEnum::Delete);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Timeline $timeline): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Timeline $timeline): bool
    {
        return false;
    }
}
