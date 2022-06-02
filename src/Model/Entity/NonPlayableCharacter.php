<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NonPlayableCharacter Entity
 *
 * @property int               $id
 * @property string            $name
 * @property int               $age
 * @property string|null       $appearance
 * @property string|null       $occupation
 * @property string|null       $personality
 * @property string|null       $history
 * @property int               $alignment_id
 * @property string|null       $notes
 * @property int               $user_id
 * @property Alignment         $alignment
 * @property User              $user
 * @property TimelineSegment[] $timeline_segments
 */
class NonPlayableCharacter extends Entity
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
        'age'               => true,
        'appearance'        => true,
        'occupation'        => true,
        'personality'       => true,
        'history'           => true,
        'alignment_id'      => true,
        'notes'             => true,
        'user_id'           => true,
        'user'              => true,
        'timeline_segments' => true,
    ];
}
