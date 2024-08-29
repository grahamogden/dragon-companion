<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\DateTime;
use Cake\ORM\Entity;

/**
 * CombatEncounter Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int $user_id
 * @property DateTime $created
 * @property int $campaign_id
 *
 * @property User $user
 * @property Campaign $campaign
 * @property CombatTurn[] $combat_turns
 * @property Participant[] $participants
 * @property Role[] $roles
 */
class CombatEncounter extends Entity
{
    public const ENTITY_NAME = 'CombatEncounters';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_CREATED = 'created';
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_USER_ID = 'user_id';

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
        self::FIELD_NAME => true,
        self::FIELD_USER_ID => false,
        self::FIELD_CREATED => false,
        self::FIELD_CAMPAIGN_ID => false,
        'user' => true,
        'campaign' => true,
        'combat_turns' => true,
        'participants' => true,
        'roles' => true,
    ];
}
