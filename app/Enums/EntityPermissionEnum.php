<?php

declare(strict_types=1);

namespace App\Enums;

enum EntityPermissionEnum: int
{
    use EnumValuesTrait;

    case Deny = 0;
    case Inherit = 1;
    case Read = 2;
    case Write = 4;
    case Delete = 8;


    case Read_or_write = 6;
    case Read_or_delete = 10;
    case Write_or_delete = 12;
    case Read_or_write_or_delete = 14;
}
