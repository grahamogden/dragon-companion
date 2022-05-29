<?php

namespace App\Model\Table;

use App\Model\Entity\CombatTurn;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CombatTurns Model
 *
 * @property CombatEncountersTable&BelongsTo $CombatEncounters
 * @property ParticipantsTable&BelongsTo     $Participants
 * @property CombatActionsTable&BelongsTo    $CombatActions
 *
 * @method CombatTurn get($primaryKey, $options = [])
 * @method CombatTurn newEntity($data = null, array $options = [])
 * @method CombatTurn[] newEntities(array $data, array $options = [])
 * @method CombatTurn|false save(EntityInterface $entity, $options = [])
 * @method CombatTurn saveOrFail(EntityInterface $entity, $options = [])
 * @method CombatTurn patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CombatTurn[] patchEntities($entities, array $data, array $options = [])
 * @method CombatTurn findOrCreate($search, callable $callback = null, $options = [])
 */
class CombatTurnsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('combat_turns');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo(
            'CombatEncounters',
            [
                'foreignKey' => 'combat_encounter_id',
                'joinType'   => 'INNER',
            ]
        );
        $this->belongsTo(
            'SourceParticipant',
            [
                'className' => 'Participants',
                'foreignKey' => 'source_participant_id',
            ]
        )
        ->setProperty('source_participant');
        $this->belongsTo(
            'TargetParticipant',
            [
                'className' => 'Participants',
                'foreignKey' => 'target_participant_id',
            ]
        )
        ->setProperty('target_participant');
        $this->belongsTo(
            'CombatActions',
            [
                'foreignKey' => 'combat_action_id',
                'joinType'   => 'INNER',
            ]
        );
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     *
     * @return Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->nonNegativeInteger('round_number')
            ->requirePresence('round_number', 'create')
            ->notEmptyString('round_number');

        $validator
            ->nonNegativeInteger('turn_order')
            ->requirePresence('turn_order', 'create')
            ->notEmptyString('turn_order');

        $validator
            ->integer('roll_total')
            ->requirePresence('roll_total', 'create')
            ->notEmptyString('roll_total');

        $validator
            ->numeric('net_action_total')
            ->allowEmptyString('net_action_total');

        $validator
            ->nonNegativeInteger('movement')
            ->notEmptyString('movement');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     *
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->existsIn(['combat_encounter_id'], 'CombatEncounters'));
        $rules->add($rules->existsIn(['source_participant_id'], 'SourceParticipant'));
        $rules->add($rules->existsIn(['target_participant_id'], 'TargetParticipant'));
        $rules->add($rules->existsIn(['combat_action_id'], 'CombatActions'));

        return $rules;
    }
}
