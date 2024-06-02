<?php

declare(strict_types=1);

namespace App\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

/**
 * DefaultRoleLevel Enum
 */
enum DefaultRoleLevel: int implements EnumLabelInterface
{
    case User = 1;
    case Admin = 10;
    case Creator = 20;

    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize(Inflector::underscore($this->name));
    }
}
