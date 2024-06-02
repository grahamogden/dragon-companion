<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RolesUser Entity
 *
 * @property int $id
 * @property int $role_id
 * @property int $user_id
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\User $user
 */
class RolesUser extends Entity
{
    public const ENTITY_NAME = 'RolesUsers';

    public const FIELD_ROLE_ID = 'role_id';
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
        self::FIELD_ROLE_ID => true,
        self::FIELD_USER_ID => true,
        'role' => true,
        'user' => true,
    ];
}
