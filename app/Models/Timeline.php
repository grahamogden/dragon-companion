<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timeline extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'timelines';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_PARENT_ID = 'parent_id';
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_USER_ID = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_DESCRIPTION,
        self::FIELD_PARENT_ID,
        self::FIELD_CAMPAIGN_ID,
        self::FIELD_USER_ID,
    ];

    public function children(): HasMany
    {
        return $this->hasMany(
            related: Timeline::class,
            foreignKey: self::FIELD_PARENT_ID
        );
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            related: Timeline::class,
            foreignKey: self::FIELD_PARENT_ID
        );
    }
}
