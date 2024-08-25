<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Campaign;
use App\Model\Entity\CampaignPermission;
use App\Model\Entity\Role;
use App\Model\Entity\RolesUser;
use App\Model\Entity\User;
use App\Services\TablePermissionsHelper\TablePermissionsHelper;
use Authorization\Identity;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\QueryInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\Validation\Validator;

/**
 * Campaigns Model
 *
 * @property UsersTable&BelongsTo $Users
 * @property CampaignPermissionsTable&HasMany $CampaignPermissions
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

    private readonly TablePermissionsHelper $tablePermissionsHelper;

    public function __construct(array $config)
    {
        parent::__construct(config: $config);
        $this->tablePermissionsHelper = new TablePermissionsHelper();
    }

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
        $this->hasMany('CampaignPermissions', [
            'foreignKey' => 'campaign_id',
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
        $rules->add($rules->existsIn([Campaign::FIELD_USER_ID], User::ENTITY_NAME), ['errorField' => Campaign::FIELD_USER_ID]);
        $rules->add(
            $rules->validCount(
                field: Campaign::FIELD_USER_ID,
                count: Campaign::MAX_CAMPAIGN_COUNT,
                operator: '<=',
                message: sprintf(
                    'You can currently only have %s campaign(s) on your account',
                    Campaign::MAX_CAMPAIGN_COUNT
                )
            )
        );

        return $rules;
    }

    public function findOneByIdWithUsers(int $id): ?Campaign
    {
        try {
            /** @var Campaign $entity */
            $entity = $this->get($id, contain: [User::ENTITY_NAME, CampaignPermission::ENTITY_NAME]);
        } catch (RecordNotFoundException $exception) {
            return null;
        }

        return $entity;
    }

    public function findByUserIdWithPermissionsCheck(Identity $identity): QueryInterface
    {
        $query = $this->find()
            ->leftJoinWith(Role::ENTITY_NAME, function ($q) {
                return $q->where([Role::ENTITY_NAME . '.' . Role::FIELD_CAMPAIGN_ID . ' = ' . Campaign::ENTITY_NAME . '.' . Campaign::FIELD_ID]);
            })
            ->leftJoinWith(Role::ENTITY_NAME . '.' . RolesUser::ENTITY_NAME, function ($q) use ($identity) {
                return $q->where([RolesUser::ENTITY_NAME . '.' . RolesUser::FIELD_USER_ID => $identity->getIdentifier()]);
            })
            ->where([
                'OR' => [
                    Campaign::ENTITY_NAME . '.' . Campaign::FIELD_USER_ID => $identity->getIdentifier(),
                    RolesUser::ENTITY_NAME . '.' . RolesUser::FIELD_USER_ID => $identity->getIdentifier(),
                ]
            ])
            ->contain(
                [CampaignPermission::ENTITY_NAME]
            )
            ->distinct([Campaign::ENTITY_NAME . '.' . Campaign::FIELD_ID]);

        return $query;
    }
}
