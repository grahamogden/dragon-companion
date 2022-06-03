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
 *
 */
class Campaign extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name'              => true,
        'synopsis'          => true,
        'campaign_users'    => true,
        'combat_encounters' => true,
        'player_characters' => true,
        'timeline_segments' => true,
        'users'             => true,
    ];
}
