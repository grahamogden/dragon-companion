<?php

declare(strict_types=1);

namespace App\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

enum RoleLevel: int implements EnumLabelInterface
{
    case Public = 10;
    case Custom = 20;
    case Player = 30;
    case Admin = 40;
    case Owner = 50;

    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize(Inflector::underscore($this->name));
    }
}
