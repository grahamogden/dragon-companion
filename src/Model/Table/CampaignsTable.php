<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Campaign;
use App\Model\Entity\User;
use Cake\Database\Query;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\Validation\Validator;
use Closure;
use Psr\SimpleCache\CacheInterface;

/**
 * Campaigns Model
 *
 * @property UsersTable&BelongsTo $Users
 * @property CharactersTable&HasMany $Characters
 * @property CombatEncountersTable&HasMany $CombatEncounters
 * @property RolesTable&HasMany $Roles
 * @property SpeciesTable&HasMany $Species
 * @property TagsTable&HasMany $Tags
 * @property TimelinesTable&HasMany $Timelines
 *
 * @method Campaign newEmptyEntity()
 * @method Campaign newEntity(array $data, array $options = [])
 * @method array<Campaign> newEntities(array $data, array $options = [])
 * @method Campaign get(mixed $primaryKey, array|string $finder = 'all', CacheInterface|string|null $cache = null, Closure|string|null $cacheKey = null, mixed ...$args)
 * @method Campaign findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method Campaign patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method array<Campaign> patchEntities(iterable $entities, array $data, array $options = [])
 * @method Campaign|false save(EntityInterface $entity, array $options = [])
 * @method Campaign saveOrFail(EntityInterface $entity, array $options = [])
 * @method iterable<Campaign>|ResultSetInterface<Campaign>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<Campaign>|ResultSetInterface<Campaign> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<Campaign>|ResultSetInterface<Campaign>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<Campaign>|ResultSetInterface<Campaign> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CampaignsTable extends Table
{
    public const TABLE_NAME = 'campaigns';

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
        $this->setDisplayField(Campaign::FIELD_NAME);
        $this->setPrimaryKey(Campaign::FIELD_ID);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Characters', [
            'foreignKey' => 'campaign_id',
        ]);
        $this->hasMany('CombatEncounters', [
            'foreignKey' => 'campaign_id',
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'campaign_id',
        ]);
        $this->hasMany('Species', [
            'foreignKey' => 'campaign_id',
        ]);
        $this->hasMany('Tags', [
            'foreignKey' => 'campaign_id',
        ]);
        $this->hasMany('Timelines', [
            'foreignKey' => 'campaign_id',
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
            ->scalar(Campaign::FIELD_NAME)
            ->maxLength(Campaign::FIELD_NAME, 250)
            ->requirePresence(Campaign::FIELD_NAME)
            ->notEmptyString(Campaign::FIELD_NAME);

        $validator
            ->scalar(Campaign::FIELD_SYNOPSIS)
            ->maxLength(Campaign::FIELD_SYNOPSIS, 1000)
            ->allowEmptyString(Campaign::FIELD_SYNOPSIS);

        $validator
            ->nonNegativeInteger(Campaign::FIELD_USER_ID)
            ->notEmptyString(Campaign::FIELD_USER_ID);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn([Campaign::FIELD_USER_ID], 'Users'), ['errorField' => Campaign::FIELD_USER_ID]);

        return $rules;
    }

    public function findByIdWithUsers(int $id): ?Campaign
    {
        try {
            /** @var Campaign $entity */
            $entity = $this->get($id, contain: User::ENTITY_NAME);
        } catch (RecordNotFoundException $exception) {
            return null;
        }

        return $entity;
    }

    public function findAllByUserId($userId): SelectQuery
    {
        return $this->find()->matching(
            User::ENTITY_NAME,
            function (Query $q) use ($userId) {
                return $q->where([User::ENTITY_NAME . '.' . User::FIELD_ID => $userId]);
            }
        );
    }
}
