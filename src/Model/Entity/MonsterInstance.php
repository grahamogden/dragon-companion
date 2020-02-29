<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MonsterInstance Entity
 *
 * @property int $id
 * @property int $monster_id
 * @property string $name
 * @property int $max_hp
 * @property int $current_hp
 *
 * @property \App\Model\Entity\Monster $monster
 * @property \App\Model\Entity\Participant[] $participants
 */
class MonsterInstance extends Entity
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
    protected $_accessible = [
        'monster_id' => true,
        'name' => true,
        'max_hp' => true,
        'current_hp' => true,
        'monster' => true,
        'participants' => true
    ];
}
