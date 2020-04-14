<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Monster Entity
 *
 * @property int           $id
 * @property int           $user_id
 * @property string        $name
 * @property int           $data_source_id
 * @property string|null   $source_location
 * @property float         $max_hit_points
 * @property int           $armour_class
 * @property int           $dexterity_modifier
 * @property int|null      $monster_instance_type_id
 *
 * @property User          $user
 * @property DataSource    $data_source
 * @property Participant[] $participants
 */
class Monster extends Entity
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
        'user_id'                  => true,
        'name'                     => true,
        'data_source_id'           => true,
        'source_location'          => true,
        'max_hit_points'           => true,
        'armour_class'             => true,
        'dexterity_modifier'       => true,
        'monster_instance_type_id' => true,
        'user'                     => true,
        'data_source'              => true,
        'participants'             => true,
    ];
}
