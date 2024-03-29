<?php

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * CombatEncounter Entity
 *
 * @property int           $id
 * @property string|null   $name
 * @property int           $user_id
 * @property \Cake\I18n\DateTime $created
 * @property int           $campaign_id
 * @property User          $user
 * @property Campaign      $campaign
 * @property Participant[] $participants
 * @property CombatTurn[]  $combat_turns
 */
class CombatEncounter extends Entity
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
        'name'         => true,
        'user_id'      => true,
        'created'      => true,
        'campaign_id'  => true,
        'user'         => true,
        'campaign'     => true,
        'participants' => true,
        'combat_turns' => true,
    ];
}
