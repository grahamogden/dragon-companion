<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ConditionsParticipant Entity
 *
 * @property int $id
 * @property int $condition_id
 * @property int $participant_id
 *
 * @property \App\Model\Entity\Condition $condition
 * @property \App\Model\Entity\Participant $participant
 */
class ConditionsParticipant extends Entity
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
        'condition_id' => true,
        'participant_id' => true,
        'condition' => true,
        'participant' => true,
    ];
}
