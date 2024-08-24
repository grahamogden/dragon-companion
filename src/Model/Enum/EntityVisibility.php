<?php

declare(strict_types=1);

namespace App\Model\Enum;

use App\Model\Enum\Interface\EnumCaseValuesInterface;
use App\Model\Enum\Trait\EnumCaseValuesTrait;
use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

enum EntityVisibility: int implements EnumLabelInterface
{
    use EnumCaseValuesTrait;

    case Public = 30;
    case Private = 70;

    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize(Inflector::underscore($this->name));
    }
}
