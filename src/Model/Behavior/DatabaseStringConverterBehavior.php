<?php
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Utility\Text;

class DatabaseStringConverterBehavior extends Behavior
{
    /**
     * List of HTML tags that can be allowed to be stored
     * They must be ordered by longest to shortest, otherwise
     * there is a risk of a tag being targeted as something such
     * as "u" before it is targeted as "ul"
     */
    const WHITE_LIST_HTML_TAGS = [
        'blockquote',
        // 'span',
        'strike',
        'strong',
        'table',
        'thead',
        'tbody',
        'em',
        'hr',
        'li',
        'ol',
        'td',
        'th',
        'tr',
        'ul',
        'b',
        'i',
        'p',
        'u',
        'a',
    ];

    const WHITE_LIST_HTML_ATTRIBUTES = [
        'href',
        'target',
        // 'style',
    ];

    public static function toDatabase($string)
    {
        $string = preg_replace(
            '/\<(\/?(' . implode('|', self::WHITE_LIST_HTML_TAGS) . '))(.*?)\>/m',
            '{{$1}}',
            $string
        );
        $string = htmlentities(
            $string,
            ENT_QUOTES,
            "UTF-8",
            false
        );
        return $string;
    }

    public static function fromDatabase($string)
    {
        $string = preg_replace(
            '/\{\{(\/?(' . implode('|', self::WHITE_LIST_HTML_TAGS) . '))(.*?)\}\}/m',
            '<$1>',
            $string
        );
        $string = addslashes($string);
        return $string;
    }

    public function beforeSave(
        EventInterface $event,
        EntityInterface $entity,
        ArrayObject $options
    ) {
        if ($entity->has('body')) {
            $entity->set('body', self::toDatabase($entity->get('body')));
        }
    }
}
