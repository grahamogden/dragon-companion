<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Campaign Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $synopsis
 * @property int $user_id
 *
 * @property User $user
 * @property CampaignPermission[] $campaign_permissions
 * @property Character[] $characters
 * @property CombatEncounter[] $combat_encounters
 * @property Role[] $roles
 * @property Species[] $species
 * @property Tag[] $tags
 * @property Timeline[] $timelines
 */
class Campaign extends Entity
{
    public const ENTITY_NAME = 'Campaigns';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_SYNOPSIS = 'synopsis';
    public const FIELD_USER_ID = 'user_id';

    public const FUNC_GET_CAMPAIGN_PERMISSIONS = 'getCampaignPermissions';

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
        self::FIELD_NAME => true,
        self::FIELD_SYNOPSIS => true,
        self::FIELD_USER_ID => true,
        'user' => true,
        'campaign_permissions' => true,
        'characters' => true,
        'combat_encounters' => true,
        'roles' => true,
        'species' => true,
        'tags' => true,
        'timelines' => true,
    ];

    protected array $_hidden = [
        self::FIELD_USER_ID,
        'campaign_users',
        'campaign_permissions',
        'combat_encounters',
        'player_characters',
        'timeline_segments',
        'users',
        '_matchingData',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getSynopsis(): string
    {
        return $this->synopsis;
    }

    public function addUser(int $userId, int $memberStatus, int $accountLevel): self
    {
        $this->users = [
            [
                'id'        => $userId,
                '_joinData' => [
                    'user_id'       => $userId,
                    'member_status' => $memberStatus, // CampaignUser::MEMBER_STATUS_ACTIVE,
                    'account_level' => $accountLevel, // CampaignUser::ACCOUNT_LEVEL_CREATOR,
                ],
            ],
        ];

        return $this;
    }

    /**
     * @return CampaignPermission[]
     */
    public function getCampaignPermissions(): array
    {
        return $this->campaign_permissions ?? [];
    }
}
