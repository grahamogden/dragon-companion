<?php

namespace App\Model\Table;

use App\Model\Entity\Participant;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Participants Model
 *
 * @property CombatEncountersTable&BelongsTo     $CombatEncounters
 * @property ConditionsTable&BelongsToMany       $Conditions
 * @property MonstersTable&BelongsToMany         $Monsters
 * @property PlayerCharactersTable&BelongsToMany $PlayerCharacters
 *
 * @method Participant get($primaryKey, $options = [])
 * @method Participant newEntity($data = null, array $options = [])
 * @method Participant[] newEntities(array $data, array $options = [])
 * @method Participant|false save(EntityInterface $entity, $options = [])
 * @method Participant saveOrFail(EntityInterface $entity, $options = [])
 * @method Participant patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Participant[] patchEntities($entities, array $data, array $options = [])
 * @method Participant findOrCreate($search, callable $callback = null, $options = [])
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
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('participants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo(
            'CombatEncounters',
            [
                'foreignKey' => 'combat_encounter_id',
                'joinType'   => 'INNER',
            ]
        );
        $this->belongsToMany(
            'Conditions',
            [
                'foreignKey'       => 'participant_id',
                'targetForeignKey' => 'condition_id',
                'joinTable'        => 'conditions_participants',
            ]
        );
        $this->belongsToMany(
            'Monsters',
            [
                'foreignKey'       => 'participant_id',
                'targetForeignKey' => 'monster_id',
                'joinTable'        => 'monsters_participants',
            ]
        );
        $this->belongsToMany(
            'PlayerCharacters',
            [
                'foreignKey'       => 'participant_id',
                'targetForeignKey' => 'player_character_id',
                'joinTable'        => 'participants_player_characters',
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
    public function validationDefault(Validator $validator)
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
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['combat_encounter_id'], 'CombatEncounters'));

        return $rules;
    }
}
