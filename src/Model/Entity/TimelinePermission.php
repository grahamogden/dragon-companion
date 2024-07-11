<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Interface\PermissionInterface;
use App\Model\Enum\RolePermission;
use Cake\ORM\Entity;

/**
 * TimelinePermission Entity
 *
 * @property int $id
 * @property int $timeline_id
 * @property int $role_id
 * @property int $permissions - enum of RolePermission
 *
 * @property Timeline $timeline
 * @property Role $role
 */
class TimelinePermission extends Entity implements PermissionInterface
{
    public const ENTITY_NAME = 'TimelinePermissions';

    public const FIELD_TIMELINE_ID = 'timeline_id';
    public const FIELD_ROLE_ID = 'role_id';
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
        self::FIELD_TIMELINE_ID => true,
        self::FIELD_ROLE_ID => true,
        self::FILED_PERMISSIONS => true,
        'timeline' => true,
        'role' => true,
    ];

    protected array $_hidden = [
        self::FILED_PERMISSIONS,
    ];

    public function getTimelineId(): int
    {
        return $this->timeline_id;
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
