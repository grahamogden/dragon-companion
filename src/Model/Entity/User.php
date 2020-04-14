<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 *
 * @property \App\Model\Entity\CombatEncounter[] $combat_encounters
 * @property \App\Model\Entity\NonPlayableCharacter[] $non_playable_characters
 * @property \App\Model\Entity\PlayerCharacter[] $player_characters
 * @property \App\Model\Entity\Puzzle[] $puzzles
 * @property \App\Model\Entity\Tag[] $tags
 * @property \App\Model\Entity\TimelineSegment[] $timeline_segments
 * @property \App\Model\Entity\Clan[] $clans
 */
class User extends Entity
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
        'username' => true,
        'password' => true,
        'email' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'combat_encounters' => true,
        'non_playable_characters' => true,
        'player_characters' => true,
        'puzzles' => true,
        'tags' => true,
        'timeline_segments' => true,
        'clans' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parent_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
