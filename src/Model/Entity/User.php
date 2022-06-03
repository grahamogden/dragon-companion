<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Http\Exception\BadRequestException;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int                    $id
 * @property string                 $username
 * @property string                 $password
 * @property string                 $email
 * @property FrozenTime             $created
 * @property FrozenTime             $modified
 * @property int                    $status
 *
 * @property Campaign[]             $campaigns
 * @property CombatEncounter[]      $combat_encounters
 * @property Monster[]              $monsters
 * @property NonPlayableCharacter[] $non_playable_characters
 * @property PlayerCharacter[]      $player_characters
 * @property Puzzle[]               $puzzles
 * @property Tag[]                  $tags
 * @property TimelineSegment[]      $timeline_segments
 */
class User extends Entity
{

    public const STATUS_INACTIVE = 0;
    public const STATUS_PENDING  = 5;
    public const STATUS_ACTIVE   = 10;

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
        'campaigns' => true,
        'combat_encounters' => true,
        'monsters' => true,
        'non_playable_characters' => true,
        'player_characters' => true,
        'puzzles' => true,
        'tags' => true,
        'timeline_segments' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }

        throw new BadRequestException('Password is missing');
    }
}
