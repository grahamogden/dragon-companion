<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlayableCharacter Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property int $age
 * @property int $max_hp
 * @property int $current_hp
 * @property int $armour_class
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Participant[] $participants
 * @property \App\Model\Entity\CharacterClass[] $character_classes
 * @property \App\Model\Entity\CharacterRace[] $character_races
 */
class PlayableCharacter extends Entity
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
        'user_id' => true,
        'first_name' => true,
        'last_name' => true,
        'age' => true,
        'max_hp' => true,
        'current_hp' => true,
        'armour_class' => true,
        'user' => true,
        'participants' => true,
        'character_classes' => true,
        'character_races' => true
    ];
}