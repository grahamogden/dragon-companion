<?php

namespace App\Models;

use App\Enums\RolePermissionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property RolePermissionEnum $campaign_permissions
 */
class RolePermission extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'role_permissions';

    public const FIELD_ID = 'id';
    public const FIELD_ROLE_ID = 'role_id';
    public const FIELD_CAMPAIGN_PERMISSIONS = 'campaign_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FIELD_ROLE_ID,
        self::FIELD_CAMPAIGN_PERMISSIONS,
    ];

    public function role(): HasOne
    {
        return $this->hasOne(related: Role::class);
    }

    public function casts(): array
    {
        return [
            self::FIELD_CAMPAIGN_PERMISSIONS => RolePermissionEnum::class
        ];
    }
}
