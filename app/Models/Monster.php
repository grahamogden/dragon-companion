<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                  $id
 * @property int                  $campaign_id
 * @property int                  $user_id
 * @property string               $name
 * @property string|null          $description
 * @property int|null             $size
 * @property int|null             $default_hit_points
 * @property int|null             $calculated_hit_points_dice_count
 * @property int|null             $calculated_hit_points_dice_type
 * @property int|null             $calculated_hit_points_modifier
 * @property int|null             $armour_class
 * @property int|null             $speed
 * @property int|null             $challenge_rating
 * 
 * @property User                 $user
 * @property Campaign             $campaign
 */
class Monster extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'monsters';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_SIZE = 'size';
    public const FIELD_DEFAULT_HIT_POINTS = 'default_hit_points';
    public const FIELD_CALCULATED_HIT_POINTS_DICE_COUNT = 'calculated_hit_points_dice_count';
    public const FIELD_CALCULATED_HIT_POINTS_DICE_TYPE = 'calculated_hit_points_dice_type';
    public const FIELD_CALCULATED_HIT_POINTS_MODIFIER = 'calculated_hit_points_modifier';
    public const FIELD_ARMOUR_CLASS = 'armour_class';
    public const FIELD_SPEED = 'speed';
    public const FIELD_CHALLENGE_RATING = 'challenge_rating';

    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_SPECIES_ID = 'species_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_DESCRIPTION,
        self::FIELD_SIZE,
        self::FIELD_DEFAULT_HIT_POINTS,
        self::FIELD_CALCULATED_HIT_POINTS_DICE_COUNT,
        self::FIELD_CALCULATED_HIT_POINTS_DICE_TYPE,
        self::FIELD_CALCULATED_HIT_POINTS_MODIFIER,
        self::FIELD_ARMOUR_CLASS,
        self::FIELD_SPEED,
        self::FIELD_CHALLENGE_RATING,
        self::FIELD_CAMPAIGN_ID,
        self::FIELD_USER_ID,
        self::FIELD_SPECIES_ID,
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
        return $this->belongsTo(related: Species::class);
    }
}
