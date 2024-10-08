<?php

declare(strict_types=1);

namespace App\Model\Enum;

use App\Model\Enum\Trait\EnumCaseValuesTrait;
use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

/**
 * UserStatus Enum
 */
enum UserStatus: int implements EnumLabelInterface
{
    use EnumCaseValuesTrait;

    case Inactive = 0;
    case Pending = 5;
    case Active = 10;

    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize(Inflector::underscore($this->name));
    }
}
