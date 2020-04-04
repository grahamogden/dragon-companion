<?php
namespace App\Model\Entity;

use Cake\Collection\Collection;
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
        'lft' => true,
        'rght' => true,
        'parent_timeline_segment' => true,
        'user' => true,
        'child_timeline_segments' => true,
        // 'tags' => true,
        'tag_string' => true,
        'non_playable_character_string' => true,
    ];

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

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    protected function _getTagString()
    {
        if (isset($this->_properties['tag_string'])) {
            return $this->_properties['tag_string'];
        }
        if (empty($this->tags)) {
            return '';
        }
        $tags = new Collection($this->tags);
        $str = $tags->reduce(function ($string, $tag) {
            return $string . $tag->title . ', ';
        }, '');
        return $str;
    }

    protected function _getNonPlayableCharacterString()
    {
        if (isset($this->_properties['non_playable_character_string'])) {
            return $this->_properties['non_playable_character_string'];
        }
        if (empty($this->non_playable_characters)) {
            return '';
        }
        $non_playable_characters = new Collection($this->non_playable_characters);
        $str = $non_playable_characters->reduce(function ($string, $nonPlayableCharacter) {
            return $string . $nonPlayableCharacter->name . ', ';
        }, '');
        return $str;
    }
}
