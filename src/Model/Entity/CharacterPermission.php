<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Interface\PermissionInterface;
use Cake\ORM\Entity;
use App\Model\Enum\RolePermission;

/**
 * CharacterPermissions Entity
 *
 * @property int $id
 * @property int $character_id
 * @property int $role_id
 * @property int $permissions
 *
 * @property Character $character
 * @property Role $role
 */
class CharacterPermission extends Entity implements PermissionInterface
{
    public const ENTITY_NAME = 'CharacterPermissions';

    public const FIELD_ROLE_ID = 'role_id';
    public const FIELD_CHARACTER_ID = 'character_id';
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
        self::FIELD_CHARACTER_ID => true,
        self::FIELD_ROLE_ID => true,
        self::FIELD_PERMISSIONS => true,
        'character' => true,
        'role' => true,
        '_matchingData',
    ];

    protected array $_hidden = [
        self::FIELD_PERMISSIONS,
    ];

    public function getCharacterId(): int
    {
        return $this->character_id;
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
