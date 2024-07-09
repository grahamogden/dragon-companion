<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\CombatTurn;
use App\Model\Enum\CombatTurnAction;
use Cake\Database\Type\EnumType;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CombatTurns Model
 *
 * @property CombatEncountersTable&BelongsTo $CombatEncounters
 * @property ParticipantsTable&BelongsTo $Participants
 * @property ParticipantsTable&BelongsTo $Participants
 *
 * @method \App\Model\Entity\CombatTurn newEmptyEntity()
 * @method \App\Model\Entity\CombatTurn newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CombatTurn> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CombatTurn get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CombatTurn findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CombatTurn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CombatTurn> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CombatTurn|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CombatTurn saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CombatTurn>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatTurn>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CombatTurn>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatTurn> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CombatTurn>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatTurn>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CombatTurn>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatTurn> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CombatTurnsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('combat_turns');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CombatEncounters', [
            'foreignKey' => CombatTurn::FIELD_COMBAT_ENCOUNTER_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Participants', [
            'foreignKey' => CombatTurn::FIELD_SOURCE_PARTICIPANT_ID,
        ]);
        $this->belongsTo('Participants', [
            'foreignKey' => CombatTurn::FIELD_TARGET_PARTICIPANT_ID,
        ]);

        $this->getSchema()->setColumnType(CombatTurn::FIELD_COMBAT_TURN_ACTION, EnumType::from(CombatTurnAction::class));
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
            ->nonNegativeInteger(CombatTurn::FIELD_COMBAT_ENCOUNTER_ID)
            ->notEmptyString(CombatTurn::FIELD_COMBAT_ENCOUNTER_ID);

        $validator
            ->nonNegativeInteger(CombatTurn::FIELD_ROUND_NUMBER)
            ->requirePresence(CombatTurn::FIELD_ROUND_NUMBER, 'create')
            ->notEmptyString(CombatTurn::FIELD_ROUND_NUMBER);

        $validator
            ->nonNegativeInteger(CombatTurn::FIELD_TURN_ORDER)
            ->requirePresence(CombatTurn::FIELD_TURN_ORDER, 'create')
            ->notEmptyString(CombatTurn::FIELD_TURN_ORDER);

        // $validator
        //     ->nonNegativeInteger(CombatTurn::FIELD_SOURCE_PARTICIPANT_ID)
        //     ->allowEmptyString(CombatTurn::FIELD_SOURCE_PARTICIPANT_ID);

        // $validator
        //     ->nonNegativeInteger(CombatTurn::FIELD_TARGET_PARTICIPANT_ID)
        //     ->allowEmptyString(CombatTurn::FIELD_TARGET_PARTICIPANT_ID);

        $validator
            ->nonNegativeInteger(CombatTurn::FIELD_COMBAT_TURN_ACTION)
            ->requirePresence(CombatTurn::FIELD_COMBAT_TURN_ACTION, 'create')
            ->notEmptyString(CombatTurn::FIELD_COMBAT_TURN_ACTION);

        $validator
            ->integer(CombatTurn::FIELD_ROLL_TOTAL)
            ->requirePresence(CombatTurn::FIELD_ROLL_TOTAL, 'create')
            ->notEmptyString(CombatTurn::FIELD_ROLL_TOTAL);

        $validator
            ->numeric(CombatTurn::FIELD_NET_ACTION_TOTAL)
            ->allowEmptyString(CombatTurn::FIELD_NET_ACTION_TOTAL);

        $validator
            ->nonNegativeInteger(CombatTurn::FIELD_MOVEMENT)
            ->notEmptyString(CombatTurn::FIELD_MOVEMENT);

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
        $rules->add($rules->existsIn([CombatTurn::FIELD_COMBAT_ENCOUNTER_ID], 'CombatEncounters'), ['errorField' => CombatTurn::FIELD_COMBAT_ENCOUNTER_ID]);
        $rules->add($rules->existsIn([CombatTurn::FIELD_SOURCE_PARTICIPANT_ID], 'Participants'), ['errorField' => CombatTurn::FIELD_SOURCE_PARTICIPANT_ID]);
        $rules->add($rules->existsIn([CombatTurn::FIELD_TARGET_PARTICIPANT_ID], 'Participants'), ['errorField' => CombatTurn::FIELD_TARGET_PARTICIPANT_ID]);

        return $rules;
    }
}
