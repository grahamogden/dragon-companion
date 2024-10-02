<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Species extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'species';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_CREATED = 'created_at';
    public const FIELD_UPDATED = 'updated_at';

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
        self::FIELD_CAMPAIGN_ID,
        self::FIELD_USER_ID,
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
