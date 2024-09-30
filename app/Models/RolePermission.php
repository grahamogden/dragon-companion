<?php

namespace App\Models;

use App\Enums\RolePermissionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \DateTime;

/**
 * @property int $id
 * @property int $user_id
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property RolePermissionEnum $campaign_permissions
 * @property RolePermissionEnum $item_permissions
 * @property RolePermissionEnum $timeline_permissions
 */
class RolePermission extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'role_permissions';

    public const FIELD_ID = 'id';
    public const FIELD_ROLE_ID = 'role_id';
    public const FIELD_CREATED = 'created_at';
    public const FIELD_UPDATED = 'updated_at';
    public const FIELD_CAMPAIGN_PERMISSIONS = 'campaign_permissions';
    public const FIELD_ITEM_PERMISSIONS = 'item_permissions';
    public const FIELD_TIMELINE_PERMISSIONS = 'timeline_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FIELD_ROLE_ID,
        self::FIELD_CAMPAIGN_PERMISSIONS,
        self::FIELD_ITEM_PERMISSIONS,
        self::FIELD_TIMELINE_PERMISSIONS,
    ];

    public function role(): HasOne
    {
        return $this->hasOne(related: Role::class);
    }

    public function casts(): array
    {
        return [
            self::FIELD_CAMPAIGN_PERMISSIONS => RolePermissionEnum::class,
            self::FIELD_ITEM_PERMISSIONS => RolePermissionEnum::class,
            self::FIELD_TIMELINE_PERMISSIONS => RolePermissionEnum::class,
        ];
    }

    public function hasCampaignPermission(RolePermissionEnum $permission): bool
    {
        return $this->campaign_permissions->value & $permission === $permission;
    }

    public function hasItemPermission(RolePermissionEnum $permission): bool
    {
        return $this->item_permissions->value & $permission === $permission;
    }

    public function hasTimelinePermission(RolePermissionEnum $permission): bool
    {
        return $this->timeline_permissions->value & $permission === $permission;
    }
}
