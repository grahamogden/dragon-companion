<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlayerCharacter Entity
 *
 * @property int              $id
 * @property int              $user_id
 * @property int              $campaign_id
 * @property string           $first_name
 * @property string           $last_name
 * @property int              $age
 * @property int              $max_hit_points
 * @property int              $armour_class
 * @property int              $dexterity_modifier
 * @property int              $alignment_id
 *
 * @property User             $user
 * @property Campaign         $campaign
 * @property Participant[]    $participants
 * @property CharacterClass[] $character_classes
 * @property CharacterRace[]  $character_races
 */
class PlayerCharacter extends Entity
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
        'user_id'            => true,
        'campaign_id'        => true,
        'first_name'         => true,
        'last_name'          => true,
        'age'                => true,
        'max_hit_points'     => true,
        'armour_class'       => true,
        'dexterity_modifier' => true,
        'alignment_id'       => true,
        'user'               => true,
        'campaign'           => true,
        'participants'       => true,
        'character_classes'  => true,
        'character_races'    => true,
    ];
}
