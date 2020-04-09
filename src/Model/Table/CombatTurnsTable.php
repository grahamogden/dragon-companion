<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CombatTurns Model
 *
 * @property \App\Model\Table\CombatEncountersTable&\Cake\ORM\Association\BelongsTo $CombatEncounters
 * @property \App\Model\Table\ParticipantsTable&\Cake\ORM\Association\BelongsTo $Participants
 * @property \App\Model\Table\ParticipantsTable&\Cake\ORM\Association\BelongsTo $Participants
 * @property \App\Model\Table\ConditionsTable&\Cake\ORM\Association\BelongsTo $Conditions
 *
 * @method \App\Model\Entity\CombatTurn get($primaryKey, $options = [])
 * @method \App\Model\Entity\CombatTurn newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CombatTurn[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CombatTurn|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CombatTurn saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CombatTurn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CombatTurn[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CombatTurn findOrCreate($search, callable $callback = null, $options = [])
 */
class CombatTurnsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('combat_turns');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CombatEncounters', [
            'foreignKey' => 'combat_enounter_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Participants', [
            'foreignKey' => 'source_participant_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Participants', [
            'foreignKey' => 'target_participant_id',
        ]);
        $this->belongsTo('Conditions', [
            'foreignKey' => 'condition_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->nonNegativeInteger('round_number')
            ->requirePresence('round_number', 'create')
            ->notEmptyString('round_number');

        $validator
            ->integer('action_result')
            ->allowEmptyString('action_result');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['combat_enounter_id'], 'CombatEncounters'));
        $rules->add($rules->existsIn(['source_participant_id'], 'Participants'));
        $rules->add($rules->existsIn(['target_participant_id'], 'Participants'));
        $rules->add($rules->existsIn(['condition_id'], 'Conditions'));

        return $rules;
    }
}
