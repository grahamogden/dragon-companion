<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Alignment Entity
 *
 * @property int                    $id
 * @property string                 $name
 * @property string|null            $description
 * @property Monster[]              $monsters
 * @property NonPlayableCharacter[] $non_playable_characters
 * @property PlayerCharacter[]      $player_characters
 */
class Alignment extends Entity
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
        'name'                    => true,
        'description'             => true,
        'monsters'                => false,
        'non_playable_characters' => false,
        'player_characters'       => false,
    ];
}
