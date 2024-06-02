<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RolesSpecies Entity
 *
 * @property int $id
 * @property int $role_id
 * @property int $species_id
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Species $species
 */
class RolesSpecies extends Entity
{
    public const ENTITY_NAME = 'RolesSpecies';

    public const FIELD_ROLE_ID = 'role_id';
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
        self::FIELD_ROLE_ID => true,
        self::FIELD_SPECIES_ID => true,
        'role' => true,
        'species' => true,
    ];
}
