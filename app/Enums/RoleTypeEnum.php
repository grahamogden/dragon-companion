<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleTypeEnum: int
{
    use EnumValuesTrait;

    case Public = 10;
    case Player = 20;
    case Custom = 30;
    case Admin = 40;
    // case Owner = 50; - Do we need this?
}
