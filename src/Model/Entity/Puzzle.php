<?php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Puzzle Entity
 *
 * @property int        $id
 * @property int        $user_id
 * @property string     $title
 * @property string     $description
 * @property string     $slug
 * @property FrozenTime $created
 * @property FrozenTime $modified
 * @property User       $user
 */
class Puzzle extends Entity
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
        'user_id'     => true,
        'title'       => true,
        'description' => true,
        'slug'        => true,
        'created'     => true,
        'modified'    => true,
        'user'        => true,
        'map'         => true,
    ];
}
