<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Role;
use App\Model\Entity\Timeline;
use App\Model\Entity\User;
use Authorization\IdentityInterface;

class TimelinePolicy
{
    use StandardPolicyTrait;

    private string $overridePermissionsTableName = Timeline::FUNC_GET_TIMELINE_PERMISSIONS;
    private string $defaultPermissionsFieldName = Role::ACCESSOR_NAME_TIMELINE_DEFAULT_PERMISSIONS;
}
