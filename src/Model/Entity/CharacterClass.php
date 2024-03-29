<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CharacterClass Entity
 *
 * @property int               $id
 * @property string            $name
 * @property PlayerCharacter[] $player_characters
 */
class CharacterClass extends Entity
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
        'name'              => true,
        'player_characters' => true,
    ];
}
