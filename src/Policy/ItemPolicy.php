<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Role;
use App\Model\Entity\Item;
use App\Model\Entity\User;
use Authorization\IdentityInterface;

class ItemPolicy
{
    use StandardPolicyTrait;

    private string $overridePermissionsTableName = Item::FUNC_GET_ITEM_PERMISSIONS;
    private string $defaultPermissionsFieldName = Role::ACCESSOR_NAME_ITEM_DEFAULT_PERMISSIONS;
}
