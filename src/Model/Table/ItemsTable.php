<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Item;
use App\Model\Entity\ItemPermission;
use App\Services\TablePermissionsHelper\TablePermissionsHelper;
use Authorization\Identity;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\QueryInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Item Model
 *
 * @property \App\Model\Table\CampaignsTable&\Cake\ORM\Association\BelongsTo $Campaigns
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CharactersTable&\Cake\ORM\Association\BelongsToMany $Characters
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsToMany $Roles
 * @property \App\Model\Table\ItemPermissionsTable&\Cake\ORM\Association\BelongsTo $ItemPermissions
 *
 * @method \App\Model\Entity\Item newEmptyEntity()
 * @method \App\Model\Entity\Item newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Item> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Item findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Item> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Item>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Item>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Item>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Item> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Item>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Item>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Item>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Item> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ItemsTable extends Table
{
    public const TABLE_NAME = 'items';

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
        $this->setDisplayField(Item::FIELD_NAME);
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsTo('Campaigns', [
            'foreignKey' => 'campaign_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ItemPermissions', [
            'foreignKey' => 'item_id',
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
            ->scalar(Item::FIELD_NAME)
            ->minLength(Item::FIELD_NAME, 3)
            ->maxLength(Item::FIELD_NAME, 255)
            ->requirePresence(Item::FIELD_NAME)
            ->notEmptyString(Item::FIELD_NAME);

        $validator
            ->nonNegativeInteger('campaign_id')
            ->notEmptyString('campaign_id');

        $validator
            ->nonNegativeInteger('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmptyString('user_id');

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
        $rules->add($rules->existsIn(['campaign_id'], 'Campaigns'), ['errorField' => 'campaign_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    public function findByIdAndCampaignId(int $id, int $campaignId): ?Item
    {
        $query = $this->find()
            ->where([
                Item::FIELD_ID => $id,
                Item::FIELD_CAMPAIGN_ID => $campaignId,
            ])
            ->contain([ItemPermission::ENTITY_NAME]);

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
                ->where([Item::ENTITY_NAME . '.' . Item::FIELD_CAMPAIGN_ID => $campaignId])
                ->contain([ItemPermission::ENTITY_NAME]),
            permissionEntityName: ItemPermission::ENTITY_NAME,
            role: $role,
        );

        return $query;
    }
}
