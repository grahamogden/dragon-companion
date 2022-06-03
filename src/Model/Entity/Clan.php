<?php

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Clan Entity
 *
 * @property int         $id
 * @property string      $name
 * @property string|null $description
 * @property FrozenTime  $created
 * @property User[]      $users
 */
class Clan extends Entity
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
        'name'        => true,
        'description' => true,
        'created'     => true,
        'user_id'     => true, // The user ID that created this Clan
        'users'       => true,
    ];
}
