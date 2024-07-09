<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Character Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $campaign_id
 * @property string $name
 * @property int $age
 * @property int $max_hit_points
 * @property int $armour_class
 * @property int $dexterity_modifier
 * @property string $notes
 *
 * @property User $user
 * @property Campaign $campaign
 * @property Participant[] $participants
 * @property Role[] $roles
 * @property Species[] $species
 */
class Character extends Entity
{
    public const ENTITY_NAME = 'Characters';

    public const FIELD_USER_ID = 'user_id';
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_NAME = 'name';
    public const FIELD_AGE = 'age';
    public const FIELD_MAX_HIT_POINTS = 'max_hit_points';
    public const FIELD_ARMOUR_CLASS = 'armour_class';
    public const FIELD_DEXTERITY_MODIFIER = 'dexterity_modifier';
    public const FIELD_NOTES = 'notes';
    public const FIELD_SPECIES_ID = 'species_id';

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
        self::FIELD_USER_ID => true,
        self::FIELD_CAMPAIGN_ID => true,
        self::FIELD_NAME => true,
        self::FIELD_AGE => true,
        self::FIELD_MAX_HIT_POINTS => true,
        self::FIELD_ARMOUR_CLASS => true,
        self::FIELD_DEXTERITY_MODIFIER => true,
        self::FIELD_NOTES => true,
        self::FIELD_SPECIES_ID => true,
        'user' => true,
        'campaign' => true,
        'participants' => true,
        'roles' => true,
    ];
}
