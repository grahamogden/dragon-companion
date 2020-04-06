<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Participant Entity
 *
 * @property int $id
 * @property int $player_character_id
 * @property int $monster_instance_id
 * @property int $order
 *
 * @property \App\Model\Entity\PlayerCharacter $player_character
 * @property \App\Model\Entity\MonsterInstance $monster_instance
 */
class Participant extends Entity
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
        'player_character_id' => true,
        'monster_instance_id' => true,
        'order'               => true,
        'player_character'    => true,
        'monster_instance'    => true,
    ];
}
