<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Interface\PermissionInterface;
use App\Model\Enum\RolePermission;
use Cake\ORM\Entity;

/**
 * SpeciesPermission Entity
 *
 * @property int $id
 * @property int $species_id
 * @property int $role_id
 * @property int $permissions - enum of RolePermission
 *
 * @property Species $species
 * @property Role $role
 */
class SpeciesPermission extends Entity implements PermissionInterface
{
    public const ENTITY_NAME = 'SpeciesPermissions';

    public const FIELD_SPECIES_ID = 'species_id';
    public const FIELD_ROLE_ID = 'role_id';
    // public const FIELD_CAN_READ = 'can_read';
    // public const FIELD_CAN_WRITE = 'can_write';
    // public const FIELD_CAN_DELETE = 'can_delete';
    // public const FIELD_CAN_PERMISSION = 'can_permission';
    public const FILED_PERMISSIONS = 'permissions';

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
        self::FIELD_SPECIES_ID => true,
        self::FIELD_ROLE_ID => true,
        // self::FIELD_CAN_READ => true,
        // self::FIELD_CAN_WRITE => true,
        // self::FIELD_CAN_DELETE => true,
        // self::FIELD_CAN_PERMISSION => true,
        self::FILED_PERMISSIONS => true,
        'species' => true,
        'role' => true,
    ];

    protected array $_hidden = [
        self::FILED_PERMISSIONS,
    ];

    public function getSpeciesId(): int
    {
        return $this->species_id;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    // public function canRead(): bool
    // {
    //     return $this->can_read;
    // }

    // public function canWrite(): bool
    // {
    //     return $this->can_write;
    // }

    // public function canDelete(): bool
    // {
    //     return $this->can_delete;
    // }

    // public function canPermission(): bool
    // {
    //     return $this->can_permission;
    // }

    public function getPermissions(): RolePermission
    {
        return RolePermission::from($this->permissions);
    }
}
