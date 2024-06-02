<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Participant;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Participants Model
 *
 * @property CombatEncountersTable&BelongsTo $CombatEncounters
 * @property CharactersTable&BelongsTo $Characters
 *
 * @method \App\Model\Entity\Participant newEmptyEntity()
 * @method \App\Model\Entity\Participant newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Participant> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Participant get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Participant findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Participant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Participant> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Participant|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Participant saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Participant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Participant>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Participant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Participant> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Participant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Participant>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Participant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Participant> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ParticipantsTable extends Table
{
    public const TABLE_NAME = 'participants';
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable(self::TABLE_NAME);
        $this->setDisplayField(Participant::FIELD_NAME);
        $this->setPrimaryKey('id');

        $this->belongsTo('CombatEncounters', [
            'foreignKey' => Participant::FIELD_COMBAT_ENCOUNTER_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Characters', [
            'foreignKey' => Participant::FIELD_CHARACTER_ID,
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger(Participant::FIELD_COMBAT_ENCOUNTER_ID)
            ->notEmptyString(Participant::FIELD_COMBAT_ENCOUNTER_ID);

        $validator
            ->nonNegativeInteger(Participant::FIELD_CHARACTER_ID)
            ->allowEmptyString(Participant::FIELD_CHARACTER_ID);

        $validator
            ->scalar(Participant::FIELD_NAME)
            ->maxLength(Participant::FIELD_NAME, 250)
            ->requirePresence(Participant::FIELD_NAME, 'create')
            ->notEmptyString(Participant::FIELD_NAME);

        $validator
            ->integer(Participant::FIELD_INITIATIVE)
            ->requirePresence(Participant::FIELD_INITIATIVE, 'create')
            ->notEmptyString(Participant::FIELD_INITIATIVE);

        $validator
            ->numeric(Participant::FIELD_STARTING_HIT_POINTS)
            ->greaterThanOrEqual(Participant::FIELD_STARTING_HIT_POINTS, 0)
            ->requirePresence(Participant::FIELD_STARTING_HIT_POINTS, 'create')
            ->notEmptyString(Participant::FIELD_STARTING_HIT_POINTS);

        $validator
            ->numeric(Participant::FIELD_CURRENT_HIT_POINTS)
            ->greaterThanOrEqual(Participant::FIELD_CURRENT_HIT_POINTS, 0)
            ->requirePresence(Participant::FIELD_CURRENT_HIT_POINTS, 'create')
            ->notEmptyString(Participant::FIELD_CURRENT_HIT_POINTS);

        $validator
            ->nonNegativeInteger(Participant::FIELD_ARMOUR_CLASS)
            ->requirePresence(Participant::FIELD_ARMOUR_CLASS, 'create')
            ->notEmptyString(Participant::FIELD_ARMOUR_CLASS);

        $validator
            ->nonNegativeInteger(Participant::FIELD_TEMPORARY_ID)
            ->requirePresence(Participant::FIELD_TEMPORARY_ID, 'create')
            ->notEmptyString(Participant::FIELD_TEMPORARY_ID);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn([Participant::FIELD_COMBAT_ENCOUNTER_ID], 'CombatEncounters'), ['errorField' => Participant::FIELD_COMBAT_ENCOUNTER_ID]);
        $rules->add($rules->existsIn([Participant::FIELD_CHARACTER_ID], 'Characters'), ['errorField' => Participant::FIELD_CHARACTER_ID]);

        return $rules;
    }
}
