<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Enum\RoleLevel;
use App\Model\Enum\RolePermission;
use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property string $role_name
 * @property int $campaign_id
 * @property int $role_level - enum of \App\Model\Enum\DefaultRoleLevel
 * @property int $campaign_default_permissions - enum of \App\Model\Enum\DefaultRole
 * @property int $species_default_permissions - enum of \App\Model\Enum\DefaultRoleLevel
 * @property int $timeline_default_permissions - enum of \App\Model\Enum\DefaultRoleLevel
 * @property int $item_default_permissions - enum of \App\Model\Enum\DefaultRoleLevel
 *
 * @property Campaign $campaigns
 * @property CampaignPermission[] $campaign_permissions
 * @property Character[] $characters
 * @property CombatEncounter[] $combat_encounters
 * @property Species[] $species
 * @property Item[] $items
 * @property Timeline[] $timelines
 * @property User[] $users
 */
class Role extends Entity
{
    public const ENTITY_NAME = 'Roles';

    public const FIELD_ID = 'id';
    public const FIELD_ROLE_NAME = 'role_name';
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_ROLE_LEVEL = 'role_level';
    public const FIELD_CAMPAIGN_DEFAULT_PERMISSIONS = 'campaign_default_permissions';
    public const ACCESSOR_NAME_CAMPAIGN_DEFAULT_PERMISSIONS = 'getCampaignDefaultPermissions';
    public const FIELD_SPECIES_DEFAULT_PERMISSIONS = 'species_default_permissions';
    public const ACCESSOR_NAME_SPECIES_DEFAULT_PERMISSIONS = 'getSpeciesDefaultPermissions';
    public const FIELD_TIMELINE_DEFAULT_PERMISSIONS = 'timeline_default_permissions';
    public const ACCESSOR_NAME_TIMELINE_DEFAULT_PERMISSIONS = 'getTimelineDefaultPermissions';
    public const FIELD_ITEM_DEFAULT_PERMISSIONS = 'item_default_permissions';
    public const ACCESSOR_NAME_ITEM_DEFAULT_PERMISSIONS = 'getItemDefaultPermissions';

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
        self::FIELD_ROLE_NAME => true,
        self::FIELD_CAMPAIGN_ID => true,
        self::FIELD_ROLE_LEVEL => true,
        self::FIELD_CAMPAIGN_DEFAULT_PERMISSIONS => true,
        self::FIELD_SPECIES_DEFAULT_PERMISSIONS => true,
        self::FIELD_TIMELINE_DEFAULT_PERMISSIONS => true,
        self::FIELD_ITEM_DEFAULT_PERMISSIONS => true,
        'campaigns' => true,
        'campaign_permissions' => true,
        'characters' => true,
        'combat_encounters' => true,
        'species' => true,
        'items' => true,
        // 'timelines' => true,
        'users' => true,
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoleName(): string
    {
        return $this->role_name;
    }

    public function getRoleLevel(): RoleLevel
    {
        return RoleLevel::from($this->role_level);
    }

    public function getCampaignId(): int
    {
        return $this->campaign_id;
    }

    public function getCampaignDefaultPermissions(): RolePermission
    {
        return RolePermission::from($this->campaign_default_permissions);
    }

    public function getSpeciesDefaultPermissions(): RolePermission
    {
        return RolePermission::from($this->species_default_permissions);
    }

    public function getTimelineDefaultPermissions(): RolePermission
    {
        return RolePermission::from($this->timeline_default_permissions);
    }

    public function getItemDefaultPermissions(): RolePermission
    {
        return RolePermission::from($this->item_default_permissions);
    }
}
