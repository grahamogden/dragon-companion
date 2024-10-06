<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $synopsis
 * 
 * @property Role[] $roles
 * @property Item[] $items
 * @property Timeline[] $timelines
 * @property Species[] $species
 * @property Character[] $characters
 * @property Monster[] $monsters
 */
class Campaign extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'campaigns';

    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_NAME = 'name';
    public const FIELD_SYNOPSIS = 'synopsis';
    public const FIELD_CREATED = 'created_at';
    public const FIELD_UPDATED = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_SYNOPSIS,
    ];

    public function roles(): HasMany
    {
        return $this->hasMany(related: Role::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(related: Item::class);
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(related: Timeline::class);
    }

    public function species(): HasMany
    {
        return $this->hasMany(related: Species::class);
    }

    public function characters(): HasMany
    {
        return $this->hasMany(related: Character::class);
    }

    public function monsters(): HasMany
    {
        return $this->hasMany(related: Monster::class);
    }
}
