<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $synopsis
 */
class Campaign extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'campaigns';

    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_NAME = 'name';
    public const FIELD_SYNOPSIS = 'synopsis';

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
}
