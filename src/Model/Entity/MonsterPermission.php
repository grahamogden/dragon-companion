<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Interface\PermissionInterface;
use Cake\ORM\Entity;
use App\Model\Enum\RolePermission;

/**
 * MonsterPermissions Entity
 *
 * @property int $id
 * @property int $monster_id
 * @property int $role_id
 * @property int $permissions
 *
 * @property Monster $monster
 * @property Role $role
 */
class MonsterPermission extends Entity implements PermissionInterface
{
    public const ENTITY_NAME = 'MonsterPermissions';

    public const FIELD_ROLE_ID = 'role_id';
    public const FIELD_MONSTER_ID = 'monster_id';
    public const FIELD_PERMISSIONS = 'permissions';

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
        self::FIELD_MONSTER_ID => true,
        self::FIELD_ROLE_ID => true,
        self::FIELD_PERMISSIONS => true,
        'monster' => true,
        'role' => true,
    ];

    protected array $_hidden = [
        self::FIELD_PERMISSIONS,
    ];

    public function getMonsterId(): int
    {
        return $this->monster_id;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function getPermissions(): RolePermission
    {
        return RolePermission::from($this->permissions);
    }
}
