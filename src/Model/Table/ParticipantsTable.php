<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Participants Model
 *
 * @property \App\Model\Table\CombatEncountersTable&\Cake\ORM\Association\BelongsTo $CombatEncounters
 * @property \App\Model\Table\ConditionsTable&\Cake\ORM\Association\BelongsToMany $Conditions
 * @property \App\Model\Table\MonstersTable&\Cake\ORM\Association\BelongsToMany $Monsters
 * @property \App\Model\Table\PlayerCharactersTable&\Cake\ORM\Association\BelongsToMany $PlayerCharacters
 *
 * @method \App\Model\Entity\Participant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Participant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Participant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Participant|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participant saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Participant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Participant findOrCreate($search, callable $callback = null, $options = [])
 */
class ParticipantsTable extends Table
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

        $this->setTable('participants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CombatEncounters', [
            'foreignKey' => 'combat_encounter_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Conditions', [
            'foreignKey' => 'participant_id',
            'targetForeignKey' => 'condition_id',
            'joinTable' => 'conditions_participants',
        ]);
        $this->belongsToMany('Monsters', [
            'foreignKey' => 'participant_id',
            'targetForeignKey' => 'monster_id',
            'joinTable' => 'monsters_participants',
        ]);
        $this->belongsToMany('PlayerCharacters', [
            'foreignKey' => 'participant_id',
            'targetForeignKey' => 'player_character_id',
            'joinTable' => 'participants_player_characters',
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
            ->integer('order')
            ->requirePresence('order', 'create')
            ->notEmptyString('order');

        $validator
            ->numeric('starting_hit_points')
            ->greaterThanOrEqual('starting_hit_points', 0)
            ->requirePresence('starting_hit_points', 'create')
            ->notEmptyString('starting_hit_points');

        $validator
            ->numeric('current_hit_points')
            ->greaterThanOrEqual('current_hit_points', 0)
            ->requirePresence('current_hit_points', 'create')
            ->notEmptyString('current_hit_points');

        $validator
            ->nonNegativeInteger('armour_class')
            ->requirePresence('armour_class', 'create')
            ->notEmptyString('armour_class');

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
        $rules->add($rules->existsIn(['combat_encounter_id'], 'CombatEncounters'));

        return $rules;
    }
}
