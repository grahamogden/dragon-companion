<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RolesTag Entity
 *
 * @property int $id
 * @property int $role_id
 * @property int $tag_id
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Tag $tag
 */
class RolesTag extends Entity
{
    public const ENTITY_NAME = 'RolesTags';

    public const FIELD_ROLE_ID = 'role_id';
    public const FIELD_TAG_ID = 'tag_id';

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
        self::FIELD_TAG_ID => true,
        'role' => true,
        'tag' => true,
    ];
}
