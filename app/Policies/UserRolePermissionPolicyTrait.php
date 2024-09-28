<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\Item;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

trait UserRolePermissionPolicyTrait
{
    /**
     * Determine whether the user can view the model.
     */
    public function getUserRolePermission(User $user, Campaign $campaign): RolePermission
    {
        /** @var  Role */
        $role = $user->roles()
            ->whereBelongsTo(related: $campaign)->firstOrFail();

        /** @var  RolePermission */
        return $role->rolePermission()->firstOrFail();
    }
}
