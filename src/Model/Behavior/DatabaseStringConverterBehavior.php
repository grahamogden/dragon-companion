<?php
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Utility\Text;

class DatabaseStringConverterBehavior extends Behavior
{
    const WHITE_LIST_HTML_TAGS = [
        'b',
        'i',
        'li',
        'ol',
        'p',
        'span',
        'strike',
        'strong',
        'table',
        'tbody',
        'td',
        'th',
        'tr',
        'u',
        'ul',
    ];

    public static function toDatabase($string)
    {
        // $string = str_replace(
        //     [
        //         '<',
        //         '>',
        //     ], [
        //         '{{',
        //         '}}',
        //     ],
        //     $string
        // );
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
        $string = str_replace(
            [
                '{{',
                '}}',
            ], [
                '<',
                '>',
            ],
            $string
        );
        $string = addslashes($string);
        return $string;
    }

    public function beforeSave(
        Event $event,
        EntityInterface $entity,
        ArrayObject $options
    ) {
        // pr($entity->visibleProperties());
        // foreach ($entity->visibleProperties() as $key => $value) {
        //     pr($key);
        //     pr($value);
        //     if (isset($value) && is_string($value)) {
        //         $entity->set($key, $this->toDatabase($value));
        //     }
        // }
        if ($entity->has('body')) {
            $entity->set('body', self::toDatabase($entity->get('body')));
        }
        // pr($entity);
        // exit;
    }
}