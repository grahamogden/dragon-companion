<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CombatTurn Entity
 *
 * @property int                           $id
 * @property int                           $combat_encounter_id
 * @property int                           $round_number
 * @property int                           $turn_order
 * @property int|null                      $source_participant_id
 * @property int|null                      $target_participant_id
 * @property int                           $combat_action_id
 * @property int                           $roll_total
 * @property float|null                    $net_action_total
 * @property int                           $movement
 * @property CombatEncounter               $combat_encounter
 * @property SourceParticipant&Participant $source_participant
 * @property TargetParticipant&Participant $target_participant
 * @property CombatAction                  $combat_action
 */
class CombatTurn extends Entity
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
        'combat_encounter_id'   => true,
        'round_number'          => true,
        'turn_order'            => true,
        'source_participant_id' => true,
        'target_participant_id' => true,
        'combat_action_id'      => true,
        'roll_total'            => true,
        'net_action_total'      => true,
        'movement'              => true,
        'combat_encounter'      => true,
        'source_participant'    => true,
        'target_participant'    => true,
        'combat_action'         => true,
    ];
}
