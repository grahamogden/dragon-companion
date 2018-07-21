<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TimelineSegment Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $body
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $slug
 * @property int $user_id
 * @property int $order_number
 * @property int $lft
 * @property int $rght
 *
 * @property \App\Model\Entity\ParentTimelineSegment $parent_timeline_segment
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ChildTimelineSegment[] $child_timeline_segments
 * @property \App\Model\Entity\Tag[] $tags
 */
class TimelineSegment extends Entity
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
        'parent_id' => true,
        'title' => true,
        'body' => true,
        'created' => true,
        'modified' => true,
        'slug' => true,
        'user_id' => true,
        'order_number' => true,
        'lft' => true,
        'rght' => true,
        'parent_timeline_segment' => true,
        'user' => true,
        'child_timeline_segments' => true,
        'tags' => true
    ];
}
