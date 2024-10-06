<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\RolePermission;
use App\Models\User;

trait UserOwnsCampaignTrait
{
    public function isCampaignOwner(User $user, Campaign $campaign): bool
    {
        /** @var RolePermission */
        return $user->id === $campaign->user_id;
    }
}
