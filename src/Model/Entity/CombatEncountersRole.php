<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CombatEncountersRole Entity
 *
 * @property int $id
 * @property int $combat_encounter_id
 * @property int $role_id
 *
 * @property CombatEncounter $combat_encounter
 * @property Role $role
 */
class CombatEncountersRole extends Entity
{
    public const ENTITY_NAME = 'CombatEncountersRoles';

    public const FIELD_ROLE_ID = 'role_id';
    public const FIELD_COMBAT_ENCOUNTER_ID = 'combat_encounter_id';

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
        self::FIELD_ROLE_ID => true,
        'combat_encounter' => true,
        'role' => true,
    ];
}
