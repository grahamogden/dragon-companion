<?php

namespace App\Model\Entity;

use Cake\Collection\Collection;
use Cake\I18n\DateTime;
use Cake\ORM\Entity;

/**
 * TimelineSegment Entity
 *
 * @property int                    $id
 * @property int                    $campaign_id
 * @property int|null               $parent_id
 * @property string                 $title
 * @property string                 $body
 * @property DateTime $created
 * @property DateTime $modified
 * @property string                 $slug
 * @property int                    $user_id
 * @property int                    $lft
 * @property int                    $rght
 * @property int                    $level
 * @property TimelineSegment        $parent_timeline_segment
 * @property User                   $user
 * @property TimelineSegment[]      $child_timeline_segments
// * @property Tag[]                  $tags
// * @property NonPlayableCharacter[] $non_playable_characters
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
    protected array $_accessible = [
        'campaign_id'             => true,
        'parent_id'               => true,
        'title'                   => true,
        'body'                    => true,
        'created'                 => true,
        'modified'                => true,
        'slug'                    => true,
        'user_id'                 => true,
        'lft'                     => true,
        'rght'                    => true,
        'level'                   => true,
        'parent_timeline_segment' => true,
        'user'                    => true,
        'child_timeline_segments' => true,
        // 'tags'                    => true,
        // 'non_playable_characters' => true,
    ];

    // protected function _getTagString()
    // {
    //     if (isset($this->_fields['tag_string'])) {
    //         return $this->_fields['tag_string'];
    //     }
    //     if (empty($this->tags)) {
    //         return '';
    //     }
    //     $tags = new Collection($this->tags);
    //     $str = $tags->reduce(function ($string, $tag) {
    //         return $string . $tag->title . ', ';
    //     }, '');
    //
    //     return $str;
    // }

    // protected function _getNonPlayableCharacterString()
    // {
    //     if (isset($this->_fields['non_playable_character_string'])) {
    //         return $this->_fields['non_playable_character_string'];
    //     }
    //     if (empty($this->non_playable_characters)) {
    //         return '';
    //     }
    //     $non_playable_characters = new Collection($this->non_playable_characters);
    //     $str = $non_playable_characters->reduce(function ($string, $nonPlayableCharacter) {
    //         return $string . $nonPlayableCharacter->name . ', ';
    //     }, '');
    //
    //     return $str;
    // }
}
