<?php

namespace App\Models;

use DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property DateTime $email_verified_at
 * @property string $remember_token
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public const TABLE_NAME = 'users';

    public const PIVOT_TABLE_ROLE_USER = Role::PIVOT_TABLE_ROLE_USER;

    public const FIELD_ID = 'id';
    public const FIELD_USERNAME = 'username';
    public const FIELD_EMAIL = 'email';
    public const FIELD_PASSWORD = 'password';
    public const FIELD_EMAIL_VERIFIED_AT = 'email_verified_at';
    public const FIELD_REMEMBER_TOKEN = 'remember_token';
    public const FIELD_CREATED = 'created_at';
    public const FIELD_UPDATED = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FIELD_USERNAME,
        self::FIELD_EMAIL,
        self::FIELD_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::FIELD_PASSWORD,
        self::FIELD_REMEMBER_TOKEN,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            self::FIELD_EMAIL_VERIFIED_AT => 'datetime',
            self::FIELD_PASSWORD => 'hashed',
        ];
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(related: Role::class)
            ->using(class: RoleUser::class)
            ->withTimestamps();
    }
}
