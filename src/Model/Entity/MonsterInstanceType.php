<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MonsterInstanceType Entity
 *
 * @property int         $id
 * @property string      $name
 * @property string|null $description
 *
 * @property Monster[]   $monsters
 */
class MonsterInstanceType extends Entity
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
        'monsters'    => true,
    ];

    /**
     * Returns the name and description concatenated with a hyphen "-"
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->name . ($this->description ? ' - ' . $this->description : '');
    }
}
