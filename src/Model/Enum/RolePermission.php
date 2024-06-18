<?php

declare(strict_types=1);

namespace App\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

enum RolePermission: int implements EnumLabelInterface
{
    case Deny = 0;
    case Inherit = 1;
    case Read = 2;
    case Write = 4;
    case Delete = 8;


    case Read_write = 6;
    case Read_delete = 10;
    case Write_delete = 12;
    case Read_write_delete = 14;

    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize(Inflector::underscore($this->name));
    }

    public static function hasReadPermission(RolePermission $permissions): bool
    {
        return self::hasReadPermissionForValue($permissions->value);
    }

    public static function hasReadPermissionForValue(int $permissions): bool
    {
        return ($permissions & self::Read->value) === self::Read->value;
    }

    public static function hasWritePermission(RolePermission $permissions): bool
    {
        return self::hasWritePermissionForValue($permissions->value);
    }

    public static function hasWritePermissionForValue(int $permissions): bool
    {
        return ($permissions & self::Write->value) === self::Write->value;
    }

    public static function hasDeletePermission(RolePermission $permissions): bool
    {
        return self::hasDeletePermissionForValue($permissions->value);
    }

    public static function hasDeletePermissionForValue(int $permissions): bool
    {
        return ($permissions & self::Delete->value) === self::Delete->value;
    }
}
