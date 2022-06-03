<?php

namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Participants Model
 *
 * @property CombatEncountersTable&BelongsTo $CombatEncounters
 * @property MonstersTable&BelongsTo         $Monsters
 * @property PlayerCharactersTable&BelongsTo $PlayerCharacters
 * @property ConditionsTable&BelongsToMany   $Conditions
 * @property ConditionsTable&BelongsTo       $CombatTurns
 *
 * @method \App\Model\Entity\Participant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Participant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Participant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Participant|false save(EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participant saveOrFail(EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participant patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Participant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Participant findOrCreate($search, callable $callback = null, $options = [])
 */
class ParticipantsTable extends Table
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

        $this->setTable('participants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CombatEncounters')
            ->setForeignKey('combat_encounter_id')
            ->setJoinType('INNER');
        $this->belongsTo('Monsters')
            ->setForeignKey('monster_id');
        $this->belongsTo('PlayerCharacters')
            ->setForeignKey('player_character_id');
        $this->hasMany('CombatTurns')
            ->setForeignKey('source_participant_id')
            ->setProperty('source_participant');
        $this->hasMany('CombatTurns')
            ->setForeignKey('target_participant_id')
            ->setProperty('target_participant');
        $this->belongsToMany(
            'Conditions',
            ['joinTable' => 'conditions_participants',]
        )
            ->setForeignKey('participant_id')
            ->setTargetForeignKey('condition_id');
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
            ->integer('initiative')
            ->requirePresence('initiative', 'create')
            ->notEmptyString('initiative');

        $validator
            ->nonNegativeInteger('starting_hit_points')
            ->requirePresence('starting_hit_points', 'create')
            ->notEmptyString('starting_hit_points');

        $validator
            ->nonNegativeInteger('current_hit_points')
            ->requirePresence('current_hit_points', 'create')
            ->notEmptyString('current_hit_points');

        $validator
            ->nonNegativeInteger('armour_class')
            ->requirePresence('armour_class', 'create')
            ->notEmptyString('armour_class');

        $validator
            ->nonNegativeInteger('temporary_id')
            ->requirePresence('temporary_id', 'create')
            ->notEmptyString('temporary_id');

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
        $rules->add($rules->existsIn(['monster_id'], 'Monsters'));
        $rules->add($rules->existsIn(['player_character_id'], 'PlayerCharacters'));

        return $rules;
    }
}
