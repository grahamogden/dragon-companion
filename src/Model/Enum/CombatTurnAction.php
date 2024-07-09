<?php
declare(strict_types=1);

namespace App\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

/**
 * CombatTurnAction Enum
 */
enum CombatTurnAction: int implements EnumLabelInterface
{
    case Pass = 0;
    case Attack = 1;
    case Heal = 2;

    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize(Inflector::underscore($this->name));
    }
}
