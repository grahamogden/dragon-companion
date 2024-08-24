<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Role;
use App\Model\Entity\Monster;

class MonsterPolicy
{
    use StandardPolicyTrait;

    private string $overridePermissionsTableName = Monster::FUNC_GET_MONSTER_PERMISSIONS;
    private string $defaultPermissionsFieldName = Role::ACCESSOR_NAME_MONSTER_DEFAULT_PERMISSIONS;
}
