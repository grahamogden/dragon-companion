<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleLevelEnum: string
{
    use EnumValuesTrait;

    case Public = 'Public';
    case Player = 'Player';
    case Custom = 'Custom';
    case Admin = 'Admin';
    // case Owner = 50; - Do we need this?
}
