<?php

namespace App\Models;

use App\Enums\RoleTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property RoleTypeEnum $role_type
 */
class Role extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'roles';

    public const PIVOT_TABLE_ROLE_USER = 'role_user';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_ROLE_TYPE = 'role_type';
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_CREATED = 'created_at';
    public const FIELD_UPDATED = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_CAMPAIGN_ID,
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(related: Campaign::class);
    }

    public function rolePermission(): HasOne
    {
        return $this->hasOne(related: RolePermission::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(related: User::class)
            ->using(class: RoleUser::class)
            ->withTimestamps();
    }

    public function casts(): array
    {
        return [
            self::FIELD_ROLE_TYPE => RoleTypeEnum::class,
        ];
    }
}
