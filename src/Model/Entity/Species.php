<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Species Entity
 *
 * @property int $id
 * @property string $species_name
 * @property int $campaign_id
 * @property int $user_id
 *
 * @property \App\Model\Entity\Campaign $campaign
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Character[] $characters
 * @property \App\Model\Entity\Role[] $roles
 */
class Species extends Entity
{

    public const ENTITY_NAME = 'Species';

    public const FIELD_SPECIES_NAME = 'species_name';
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
        self::FIELD_SPECIES_NAME => true,
        self::FIELD_CAMPAIGN_ID => true,
        self::FIELD_USER_ID => true,
        'campaign' => true,
        'user' => true,
        'characters' => true,
        'roles' => true,
    ];
}
