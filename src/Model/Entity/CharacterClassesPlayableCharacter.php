<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CharacterClassesPlayableCharacter Entity
 *
 * @property int $id
 * @property int $character_class_id
 * @property int $player_character_id
 *
 * @property \App\Model\Entity\CharacterClass $character_class
 * @property \App\Model\Entity\PlayableCharacter $playable_character
 */
class CharacterClassesPlayableCharacter extends Entity
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
        'character_class_id' => true,
        'player_character_id' => true,
        'character_class' => true,
        'playable_character' => true
    ];
}
