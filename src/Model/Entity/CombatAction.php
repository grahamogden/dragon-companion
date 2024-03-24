<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CombatAction Entity
 *
 * @property int          $id
 * @property string|null  $name
 * @property string|null  $description
 * @property CombatTurn[] $combat_turns
 */
class CombatAction extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        'name'         => true,
        'description'  => true,
        'combat_turns' => true,
    ];
}
