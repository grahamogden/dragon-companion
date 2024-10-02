<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $campaign_id
 * @property string $name
 * @property int|null $age
 * @property int|null $max_hit_points
 * @property int|null $armour_class
 * @property int|null $dexterity_modifier
 * @property string|null $appearance
 * @property string|null $notes
 *
 * @property User $user
 * @property Campaign $campaign
 * @property Species $species
 */
class Character extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'characters';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_AGE = 'age';
    public const FIELD_MAX_HIT_POINTS = 'max_hit_points';
    public const FIELD_ARMOUR_CLASS = 'armour_class';
    public const FIELD_DEXTERITY_MODIFIER = 'dexterity_modifier';
    public const FIELD_APPEARANCE = 'appearance';
    public const FIELD_NOTES = 'notes';

    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_SPECIES_ID = 'species_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_NAME,
        self::FIELD_AGE,
        self::FIELD_MAX_HIT_POINTS,
        self::FIELD_ARMOUR_CLASS,
        self::FIELD_DEXTERITY_MODIFIER,
        self::FIELD_APPEARANCE,
        self::FIELD_NOTES,
        self::FIELD_SPECIES_ID,
        self::FIELD_CAMPAIGN_ID,
        self::FIELD_USER_ID,
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(related: Campaign::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }

    public function species(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }
}
