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
 * @property &\Cake\ORM\Association\BelongsTo $SourceParticipants
 * @property &\Cake\ORM\Association\BelongsTo $TargetParticipants
 * @property &\Cake\ORM\Association\BelongsTo $CombatActions
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
        $this->belongsTo('SourceParticipants', [
            'foreignKey' => 'source_participant_id',
        ]);
        $this->belongsTo('TargetParticipants', [
            'foreignKey' => 'target_participant_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CombatActions', [
            'foreignKey' => 'combat_action_id',
            'joinType' => 'INNER',
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['combat_enounter_id'], 'CombatEncounters'));
        $rules->add($rules->existsIn(['source_participant_id'], 'SourceParticipants'));
        $rules->add($rules->existsIn(['target_participant_id'], 'TargetParticipants'));
        $rules->add($rules->existsIn(['combat_action_id'], 'CombatActions'));

        return $rules;
    }
}
