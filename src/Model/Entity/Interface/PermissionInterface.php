<?php

declare(strict_types=1);

namespace App\Model\Entity\Interface;

use App\Model\Enum\RolePermission;
use Cake\Datasource\EntityInterface;

interface PermissionInterface extends EntityInterface
{
    public function getPermissions(): RolePermission;

    public function getRoleId(): int;
}
