<?php

namespace App\Policies;

use App\Enums\RolePermissionEnum;
use App\Models\Campaign;
use App\Models\Species;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpeciesPolicy
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
    public function view(User $user, Species $species, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasSpeciesPermission(permission: RolePermissionEnum::Read);
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
            ->hasSpeciesPermission(permission: RolePermissionEnum::Write);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Species $species, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasSpeciesPermission(permission: RolePermissionEnum::Write);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Species $species, Campaign $campaign): bool
    {
        if (((bool) $user->id) === false) {
            return false;
        }

        return $this->getUserRolePermission(user: $user, campaign: $campaign)
            ->hasSpeciesPermission(permission: RolePermissionEnum::Delete);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Species $species): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Species $species): bool
    {
        return false;
    }
}
