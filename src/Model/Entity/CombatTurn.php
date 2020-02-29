<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CombatTurn Entity
 *
 * @property int $id
 * @property int $combat_enounter_id
 * @property int $round_number
 * @property int $source_participant_id
 * @property int $target_participant_id
 * @property int $action_result
 * @property int $condition_id
 *
 * @property \App\Model\Entity\CombatEncounter $combat_encounter
 * @property \App\Model\Entity\Participant $participant
 * @property \App\Model\Entity\Condition $condition
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
    protected $_accessible = [
        'combat_enounter_id' => true,
        'round_number' => true,
        'source_participant_id' => true,
        'target_participant_id' => true,
        'action_result' => true,
        'condition_id' => true,
        'combat_encounter' => true,
        'participant' => true,
        'condition' => true
    ];
}
