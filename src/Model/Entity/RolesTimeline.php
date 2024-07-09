<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RolesTimeline Entity
 *
 * @property int $id
 * @property int $role_id
 * @property int $timeline_id
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Timeline $timeline
 */
class RolesTimeline extends Entity
{
    public const ENTITY_NAME = 'RolesTimelines';

    public const FIELD_ROLE_ID = 'role_id';
    public const FIELD_TIMELINE_ID = 'timeline_id';

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
        self::FIELD_TIMELINE_ID => true,
        'role' => true,
        'timeline' => true,
    ];
}
