<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Role;
use App\Model\Entity\Character;

class CharacterPolicy
{
    use StandardPolicyTrait;

    private string $overridePermissionsTableName = Character::FUNC_GET_CHARACTER_PERMISSIONS;
    private string $defaultPermissionsFieldName = Role::ACCESSOR_NAME_CHARACTER_DEFAULT_PERMISSIONS;
}
