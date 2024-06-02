<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\CombatEncounter;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CombatEncounters Model
 *
 * @property UsersTable&BelongsTo $Users
 * @property CampaignsTable&BelongsTo $Campaigns
 * @property CombatTurnsTable&HasMany $CombatTurns
 * @property ParticipantsTable&HasMany $Participants
 * @property RolesTable&BelongsToMany $Roles
 *
 * @method \App\Model\Entity\CombatEncounter newEmptyEntity()
 * @method \App\Model\Entity\CombatEncounter newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CombatEncounter> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CombatEncounter get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CombatEncounter findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CombatEncounter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CombatEncounter> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CombatEncounter|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CombatEncounter saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CombatEncounter>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatEncounter>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CombatEncounter>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatEncounter> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CombatEncounter>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatEncounter>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CombatEncounter>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatEncounter> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CombatEncountersTable extends Table
{
    public const TABLE_NAME = 'combat_encounters';

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
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Campaigns', [
            'foreignKey' => 'campaign_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('CombatTurns', [
            'foreignKey' => 'combat_encounter_id',
        ]);
        $this->hasMany('Participants', [
            'foreignKey' => 'combat_encounter_id',
        ]);
        $this->belongsToMany('Roles', [
            'foreignKey' => 'combat_encounter_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'combat_encounters_roles',
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
            ->scalar(CombatEncounter::FIELD_NAME)
            ->maxLength(CombatEncounter::FIELD_NAME, 250)
            ->allowEmptyString(CombatEncounter::FIELD_NAME);

        $validator
            ->nonNegativeInteger(CombatEncounter::FIELD_USER_ID)
            ->notEmptyString(CombatEncounter::FIELD_USER_ID);

        $validator
            ->nonNegativeInteger(CombatEncounter::FIELD_CAMPAIGN_ID)
            ->notEmptyString(CombatEncounter::FIELD_CAMPAIGN_ID);

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
        $rules->add($rules->existsIn([CombatEncounter::FIELD_USER_ID], 'Users'), ['errorField' => CombatEncounter::FIELD_USER_ID]);
        $rules->add($rules->existsIn([CombatEncounter::FIELD_CAMPAIGN_ID], 'Campaigns'), ['errorField' => CombatEncounter::FIELD_CAMPAIGN_ID]);

        return $rules;
    }
}
