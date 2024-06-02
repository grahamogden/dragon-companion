<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property string $role_name
 * @property int $campaign_id
 *
 * @property \App\Model\Entity\Campaign[] $campaigns
 * @property \App\Model\Entity\Character[] $characters
 * @property \App\Model\Entity\CombatEncounter[] $combat_encounters
 * @property \App\Model\Entity\Species[] $species
 * @property \App\Model\Entity\Tag[] $tags
 * @property \App\Model\Entity\Timeline[] $timelines
 * @property \App\Model\Entity\User[] $users
 */
class Role extends Entity
{
    public const ENTITY_NAME = 'Roles';

    public const FIELD_ROLE_NAME = 'role_name';
    public const FIELD_CAMPAIGN_ID = 'campaign_id';

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
        self::FIELD_ROLE_NAME => true,
        self::FIELD_CAMPAIGN_ID => true,
        'campaigns' => true,
        'characters' => true,
        'combat_encounters' => true,
        'species' => true,
        'tags' => true,
        'timelines' => true,
        'users' => true,
    ];
}
