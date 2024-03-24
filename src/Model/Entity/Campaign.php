<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Campaign Entity
 *
 * @property int               $id
 * @property string            $name
 * @property string|null       $synopsis
 * @property CampaignUser[]    $campaign_users
 * @property CombatEncounter[] $combat_encounters
 * @property PlayerCharacter[] $player_characters
 * @property TimelineSegment[] $timeline_segments
 * @property User[]            $users
 *
 */
class Campaign extends Entity
{
    protected array $_hidden = [
        'campaign_users',
        'combat_encounters',
        'player_characters',
        'timeline_segments',
        'users',
        '_matchingData',
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        // 'name'              => false,
        // 'synopsis'          => false,
        // 'campaign_users'    => false,
        // 'combat_encounters' => false,
        // 'player_characters' => false,
        // 'timeline_segments' => false,
        // 'users'             => false,
        '*'                 => false,
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
}
