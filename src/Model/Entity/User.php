<?php

declare(strict_types=1);

namespace App\Model\Entity;

use ArrayAccess;
use Authentication\IdentityInterface;
use Cake\I18n\DateTime;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property DateTime $created
 * @property DateTime $modified
 * @property int $status
 * @property string $external_user_id
 *
 * @property Campaign[] $campaigns
 * @property Character[] $characters
 * @property CombatEncounter[] $combat_encounters
 * @property Species[] $species
 * @property Tag[] $tags
 * @property Timeline[] $timelines
 * @property Role[] $roles
 */
class User extends Entity implements IdentityInterface
{
    public const ENTITY_NAME = 'Users';

    public const STATUS_INACTIVE = 0;
    public const STATUS_PENDING  = 5;
    public const STATUS_ACTIVE   = 10;
    public const USER_STATUSES = [
        self::STATUS_INACTIVE,
        self::STATUS_PENDING,
        self::STATUS_ACTIVE,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_USERNAME = 'username';
    public const FIELD_EMAIL = 'email';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_STATUS = 'status';
    public const FIELD_EXTERNAL_USER_ID = 'external_user_id';

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        self::FIELD_USERNAME => true,
        self::FIELD_EMAIL => true,
        self::FIELD_CREATED => true,
        self::FIELD_MODIFIED => true,
        self::FIELD_STATUS => true,
        self::FIELD_EXTERNAL_USER_ID => true,
        'campaigns' => true,
        'characters' => true,
        'combat_encounters' => true,
        'species' => true,
        'tags' => true,
        'timelines' => true,
        'roles' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected array $_hidden = [
        '_matchingData',
    ];

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setStatus(int $status): self
    {
        // if (!in_array($status, self::USER_STATUSES)) {
        //     throw new BadRequestException('Status is invalid');
        // }

        $this->set(self::FIELD_STATUS, $status);

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setExternalUserId(string $externalUserId): self
    {
        $this->set(self::FIELD_EXTERNAL_USER_ID, $externalUserId);
        return $this;
    }

    public function getExternalUserId(): string
    {
        return $this->external_user_id;
    }

    public function getIdentifier(): array | string | int | null
    {
        return $this->id;
    }

    public function getOriginalData(): array | ArrayAccess
    {
        return $this;
    }
}
