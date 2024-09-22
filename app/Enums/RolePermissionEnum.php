<?php

declare(strict_types=1);

namespace App\Enums;

enum RolePermissionEnum: int
{
    use EnumValuesTrait;

    case Deny = 0;
    case Read = 1;
    case Write = 2;
    case Delete = 4;


    case Read_or_write = 3;
    case Read_or_delete = 5;
    case Write_or_delete = 6;
    case Read_or_write_or_delete = 7;
}
