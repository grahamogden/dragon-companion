<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CombatTurn Entity
 *
 * @property int $id
 * @property int $combat_encounter_id
 * @property int $round_number
 * @property int $turn_order
 * @property int|null $source_participant_id
 * @property int|null $target_participant_id
 * @property int $combat_action_id
 * @property int $roll_total
 * @property float|null $net_action_total
 * @property int $movement
 *
 * @property CombatEncounter $combat_encounter
 * @property Participant $participant
 */
class CombatTurn extends Entity
{
    public const ENTITY_NAME = 'CombatTurns';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_COMBAT_ENCOUNTER_ID = 'combat_encounter_id';
    public const FIELD_ROUND_NUMBER = 'round_number';
    public const FIELD_TURN_ORDER = 'turn_order';
    public const FIELD_SOURCE_PARTICIPANT_ID = 'source_participant_id';
    public const FIELD_TARGET_PARTICIPANT_ID = 'target_participant_id';
    public const FIELD_COMBAT_TURN_ACTION = 'combat_turn_action';
    public const FIELD_ROLL_TOTAL = 'roll_total';
    public const FIELD_NET_ACTION_TOTAL = 'net_action_total';
    public const FIELD_MOVEMENT = 'movement';

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        self::FIELD_COMBAT_ENCOUNTER_ID => true,
        self::FIELD_ROUND_NUMBER => true,
        self::FIELD_TURN_ORDER => true,
        self::FIELD_SOURCE_PARTICIPANT_ID => true,
        self::FIELD_TARGET_PARTICIPANT_ID => true,
        self::FIELD_COMBAT_TURN_ACTION => true,
        self::FIELD_ROLL_TOTAL => true,
        self::FIELD_NET_ACTION_TOTAL => true,
        self::FIELD_MOVEMENT => true,
        'combat_encounter' => true,
        'participant' => true,
    ];
}
