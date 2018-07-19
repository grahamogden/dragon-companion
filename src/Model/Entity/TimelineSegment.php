<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
// the Collection class
use Cake\Collection\Collection;

class TimelineSegment extends Entity
{
    protected $_accessible = [
        '*'           => true,
        'id'          => false,
        'parent_id'   => false,
        'title'       => true,
        'body'        => true,
        'slug'        => true,
        'created'     => false,
        'modified'    => false,
        'previous_id' => true,
    ];

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
        return trim($str, ', ');
    }
}