<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;

trait UserRolePermissionPolicyTrait
{
    public function getUserRole(User $user, Campaign $campaign): Role
    {
        /** @var Role */
        return $user->roles()
            ->whereBelongsTo(related: $campaign)
            ->firstOrFail();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function getUserRolePermission(User $user, Campaign $campaign): RolePermission
    {
        /** @var RolePermission */
        return $this->getUserRole(user: $user, campaign: $campaign)
            ->rolePermission()
            ->firstOrFail();
    }
}
