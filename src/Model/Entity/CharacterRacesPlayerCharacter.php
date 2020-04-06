<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CharacterRacesPlayerCharacter Entity
 *
 * @property int $id
 * @property int $character_race_id
 * @property int $player_character_id
 *
 * @property \App\Model\Entity\CharacterRace $character_race
 * @property \App\Model\Entity\PlayerCharacter $player_character
 */
class CharacterRacesPlayerCharacter extends Entity
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
        'character_race_id' => true,
        'player_character_id' => true,
        'character_race' => true,
        'player_character' => true,
    ];
}
