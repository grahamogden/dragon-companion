<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Monster Entity
 *
 * @property int $id
 * @property string $name
 * @property int $data_source_id
 * @property float $max_hit_points
 * @property int $armour_class
 * @property string|null $source_location
 *
 * @property \App\Model\Entity\DataSource $data_source
 * @property \App\Model\Entity\Participant[] $participants
 */
class Monster extends Entity
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
        'data_source_id' => true,
        'max_hit_points' => true,
        'armour_class' => true,
        'source_location' => true,
        'data_source' => true,
        'participants' => true,
    ];
}
