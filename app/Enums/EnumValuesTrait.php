<?php

declare(strict_types=1);

namespace App\Enums;

trait EnumValuesTrait
{
    public static function values(): array
    {
        return array_column(array: self::cases(), column_key: 'value');
    }
}
