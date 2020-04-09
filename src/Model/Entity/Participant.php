<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Participant Entity
 *
 * @property int $id
 * @property int $order
 * @property int $combat_encounter_id
 * @property float $starting_hit_points
 * @property float $current_hit_points
 * @property int $armour_class
 *
 * @property \App\Model\Entity\CombatEncounter $combat_encounter
 * @property \App\Model\Entity\Condition[] $conditions
 * @property \App\Model\Entity\Monster[] $monsters
 * @property \App\Model\Entity\PlayerCharacter[] $player_characters
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
        'order'               => true,
        'combat_encounter_id' => true,
        'starting_hit_points' => true,
        'current_hit_points'  => true,
        'armour_class'        => true,
        'combat_encounter'    => true,
        'conditions'          => true,
        'monsters'            => true,
        'player_characters'   => true,
    ];
}
