<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Participant Entity
 *
 * @property int             $id
 * @property int             $initiative
 * @property int             $combat_encounter_id
 * @property float           $starting_hit_points
 * @property float           $current_hit_points
 * @property int             $armour_class
 * @property int|null        $monster_id
 * @property int|null        $player_character_id
 * @property int             $temporary_id
 *
 * @property CombatEncounter $combat_encounter
 * @property Monster         $monster
 * @property PlayerCharacter $player_character
 * @property Condition[]     $conditions
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
        'initiative'          => true,
        'combat_encounter_id' => true,
        'starting_hit_points' => true,
        'current_hit_points'  => true,
        'armour_class'        => true,
        'temporary_id'        => true,
        'monster_id'          => true,
        'player_character_id' => true,
        'combat_encounter'    => true,
        'monster'             => true,
        'player_character'    => true,
        'conditions'          => true,
    ];
}
