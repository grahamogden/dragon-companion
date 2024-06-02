<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CampaignPermission Entity
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $role_id
 * @property bool $can_read
 * @property bool $can_write
 * @property bool $can_delete
 * @property bool $can_permission
 *
 * @property Campaign $campaign
 * @property Role $role
 */
class CampaignPermission extends Entity
{
    public const ENTITY_NAME = 'CampaignPermissions';

    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_ROLE_ID = 'role_id';
    public const FIELD_CAN_READ = 'can_read';
    public const FIELD_CAN_WRITE = 'can_write';
    public const FIELD_CAN_DELETE = 'can_delete';
    public const FIELD_CAN_PERMISSION = 'can_permission';

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
        self::FIELD_CAMPAIGN_ID => true,
        self::FIELD_ROLE_ID => true,
        self::FIELD_CAN_READ => true,
        self::FIELD_CAN_WRITE => true,
        self::FIELD_CAN_DELETE => true,
        self::FIELD_CAN_PERMISSION => true,
        'campaign' => true,
        'role' => true,
    ];

    public function getCampaignId(): int
    {
        return $this->campaign_id;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function canRead(): bool
    {
        return $this->can_read;
    }

    public function canWrite(): bool
    {
        return $this->can_write;
    }

    public function canDelete(): bool
    {
        return $this->can_delete;
    }

    public function canPermission(): bool
    {
        return $this->can_permission;
    }
}
