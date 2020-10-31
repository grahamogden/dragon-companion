<?php

namespace App\Model\Table;

use App\Model\Entity\CampaignUser;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampaignUsers Model
 *
 * @property CampaignsTable&BelongsTo $Campaigns
 * @property UsersTable&BelongsTo     $Users
 *
 * @method CampaignUser get($primaryKey, $options = [])
 * @method CampaignUser newEntity($data = null, array $options = [])
 * @method CampaignUser[] newEntities(array $data, array $options = [])
 * @method CampaignUser|false save(EntityInterface $entity, $options = [])
 * @method CampaignUser saveOrFail(EntityInterface $entity, $options = [])
 * @method CampaignUser patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CampaignUser[] patchEntities($entities, array $data, array $options = [])
 * @method CampaignUser findOrCreate($search, callable $callback = null, $options = [])
 */
class CampaignUsersTable extends Table
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

        $this->setTable('campaign_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo(
            'Campaigns',
            [
                'foreignKey' => 'campaign_id',
                'joinType'   => 'INNER',
            ]
        );
        $this->belongsTo(
            'Users',
            [
                'foreignKey' => 'user_id',
                'joinType'   => 'INNER',
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
            ->integer('member_status')
            ->notEmptyString('member_status');

        $validator
            ->integer('account_level')
            ->notEmptyString('account_level');

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
        $rules->add($rules->existsIn(['campaign_id'], 'Campaigns'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
