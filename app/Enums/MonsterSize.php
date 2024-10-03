<?php

namespace App\Enums;

enum MonsterSize: string
{
    use EnumValuesTrait;

    case Unknown = 'Unknown';
    case Tiny = 'Tiny';
    case Small = 'Small';
    case Medium = 'Medium';
    case Large = 'Large';
    case Huge = 'Huge';
    case Gargantuan = 'Gargantuan';
}
