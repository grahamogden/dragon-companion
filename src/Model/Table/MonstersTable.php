<?php

namespace App\Model\Table;

use App\Model\Entity\Campaign;
use App\Model\Entity\Monster;
use App\Model\Entity\MonsterPermission;
use App\Model\Entity\User;
use App\Model\Enum\EntityVisibility;
use App\Model\Enum\MonsterSize;
use App\Services\TablePermissionsHelper\TablePermissionsHelper;
use Authorization\Identity;
use Cake\Datasource\QueryInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Monsters Model
 *
 * @property UsersTable&BelongsTo     $Users
 * @property CampaignsTable&BelongsTo $Campaigns
 * 
 * @method \App\Model\Entity\Character newEmptyEntity()
 * @method \App\Model\Entity\Character newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Character> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Character get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Character findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Character patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Character> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Character|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Character saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Character>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Character>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Character>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Character> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Character>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Character>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Character>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Character> deleteManyOrFail(iterable $entities, array $options = [])
 */
class MonstersTable extends Table
{
    public const TABLE_NAME = 'monsters';

    private readonly TablePermissionsHelper $tablePermissionsHelper;

    public function __construct(array $config)
    {
        parent::__construct(config: $config);
        $this->tablePermissionsHelper = new TablePermissionsHelper();
    }

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

        $this->setTable(self::TABLE_NAME);
        $this->setDisplayField(Monster::FIELD_NAME);
        $this->setPrimaryKey(Monster::FIELD_ID);

        $this->belongsTo(User::ENTITY_NAME, [
            'foreignKey' => Monster::FIELD_USER_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsTo(Campaign::ENTITY_NAME, [
            'foreignKey' => Monster::FIELD_CAMPAIGN_ID,
            'joinType' => 'INNER',
        ]);
        $this->hasMany(MonsterPermission::ENTITY_NAME, [
            'foreignKey' => MonsterPermission::FIELD_MONSTER_ID,
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     *
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar(Monster::FIELD_NAME)
            ->maxLength(Monster::FIELD_NAME, 250)
            ->notEmptyString(Monster::FIELD_NAME);

        $validator
            ->scalar(Monster::FIELD_VISIBILTY)
            ->notEmptyString(Monster::FIELD_VISIBILTY)
            ->inList(Monster::FIELD_VISIBILTY, EntityVisibility::getValues());

        $validator
            ->scalar(Monster::FIELD_SIZE)
            ->notEmptyString(Monster::FIELD_SIZE)
            ->inList(Monster::FIELD_SIZE, MonsterSize::getValues());

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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn([Monster::FIELD_USER_ID], User::ENTITY_NAME));

        return $rules;
    }

    public function findByIdAndCampaignId(int $campaignId, int $id): ?Monster
    {
        $query = $this->find()
            ->where([
                Monster::ENTITY_NAME . '.' . Monster::FIELD_ID => $id,
                Monster::ENTITY_NAME . '.' . Monster::FIELD_CAMPAIGN_ID => $campaignId,
            ])
            ->contain([MonsterPermission::ENTITY_NAME]);

        return $query->first();
    }

    public function findByCampaignIdWithPermissionsCheck(Identity $identity, int $campaignId): QueryInterface
    {
        $role = $this->tablePermissionsHelper->getUserRoleForCampaignOrThrowUnauthorizedError(
            identity: $identity,
            campaignId: $campaignId,
        );

        $query = $this->tablePermissionsHelper->addReadPermissionsChecksToQuery(
            query: $this->find()
                ->where([Monster::ENTITY_NAME . '.' . Monster::FIELD_CAMPAIGN_ID => $campaignId])
                ->contain([MonsterPermission::ENTITY_NAME]),
            permissionEntityName: MonsterPermission::ENTITY_NAME,
            role: $role,
        );

        return $query;
    }
}
