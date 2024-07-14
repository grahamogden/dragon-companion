<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Enum\RolePermission;
use Cake\ORM\Entity;

/**
 * CampaignPermission Entity
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $role_id
 * @property int $permissions
 *
 * @property Campaign $campaign
 * @property Role $role
 */
class CampaignPermission extends Entity
{
    public const ENTITY_NAME = 'CampaignPermissions';

    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_ROLE_ID = 'role_id';
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
        self::FIELD_CAMPAIGN_ID => true,
        self::FIELD_ROLE_ID => true,
        self::FIELD_PERMISSIONS => true,
        'campaign' => true,
        'role' => true,
    ];

    protected array $_hidden = [
        self::FIELD_PERMISSIONS,
    ];

    public function getCampaignId(): int
    {
        return $this->campaign_id;
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
