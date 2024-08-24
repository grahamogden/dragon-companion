<?php

declare(strict_types=1);

namespace App\Model\Enum;

use App\Model\Enum\Trait\EnumCaseValuesTrait;
use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

enum MonsterSize: int implements EnumLabelInterface
{
    use EnumCaseValuesTrait;

    case Unknown = 0;
    case Tiny = 20;
    case Small = 30;
    case Medium = 40;
    case Large = 50;
    case Huge = 60;
    case Gargantuan = 70;

    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize(Inflector::underscore($this->name));
    }
}
