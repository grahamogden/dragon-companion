<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Table\CampaignsTable;
use App\Model\Table\RolesTable;
use App\Model\Entity\CampaignPermission;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampaignPermissions Model
 *
 * @property CampaignsTable&BelongsTo $Campaigns
 * @property RolesTable&BelongsTo $Roles
 *
 * @method \App\Model\Entity\CampaignPermission newEmptyEntity()
 * @method \App\Model\Entity\CampaignPermission newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CampaignPermission> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CampaignPermission get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CampaignPermission findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CampaignPermission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CampaignPermission> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CampaignPermission|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CampaignPermission saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CampaignPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CampaignPermission>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CampaignPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CampaignPermission> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CampaignPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CampaignPermission>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CampaignPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CampaignPermission> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CampaignPermissionsTable extends Table
{
    public const TABLE_NAME = 'campaign_permissions';

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
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Campaigns', [
            'foreignKey' => 'campaign_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
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
            ->nonNegativeInteger('campaign_id')
            ->notEmptyString('campaign_id');

        $validator
            ->nonNegativeInteger('role_id')
            ->notEmptyString('role_id');

        $validator
            ->boolean(CampaignPermission::FIELD_CAN_READ);

        $validator
            ->boolean(CampaignPermission::FIELD_CAN_WRITE);

        $validator
            ->boolean(CampaignPermission::FIELD_CAN_DELETE);

        $validator
            ->boolean(CampaignPermission::FIELD_CAN_PERMISSION);

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
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }
}
