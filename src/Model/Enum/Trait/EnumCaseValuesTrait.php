<?php

namespace App\Model\Enum\Trait;

use App\Model\Enum\Interface\EnumCaseValuesInterface;

trait EnumCaseValuesTrait
{
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
