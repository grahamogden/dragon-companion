<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampaignsRoles Model
 *
 * @property \App\Model\Table\CampaignsTable&\Cake\ORM\Association\BelongsTo $Campaigns
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\CampaignsRole newEmptyEntity()
 * @method \App\Model\Entity\CampaignsRole newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CampaignsRole> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CampaignsRole get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CampaignsRole findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CampaignsRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CampaignsRole> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CampaignsRole|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CampaignsRole saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CampaignsRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CampaignsRole>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CampaignsRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CampaignsRole> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CampaignsRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CampaignsRole>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CampaignsRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CampaignsRole> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CampaignsRolesTable extends Table
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

        $this->setTable('campaigns_roles');
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
