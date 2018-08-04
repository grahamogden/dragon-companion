<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NonPlayableCharacter Entity
 *
 * @property int $id
 * @property string $name
 * @property int $age
 * @property string $appearance
 * @property string $occupation
 * @property string $personality
 * @property string $history
 * @property int $alignment
 * @property string $notes
 * @property int $tag_id
 *
 * @property \App\Model\Entity\Tag $tag
 */
class NonPlayableCharacter extends Entity
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
        'name' => true,
        'age' => true,
        'appearance' => true,
        'occupation' => true,
        'personality' => true,
        'history' => true,
        'alignment' => true,
        'notes' => true,
        'tag_id' => true,
        'tag' => true
    ];
}
