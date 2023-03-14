<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClansUsers Model
 *
 * @property \App\Model\Table\ClansTable&\Cake\ORM\Association\BelongsTo $Clans
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ClansUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClansUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClansUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClansUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClansUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClansUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClansUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClansUser findOrCreate($search, callable $callback = null, $options = [])
 */
class ClansUsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('clans_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clans');
        $this->belongsTo('Users');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('member_status')
            ->requirePresence('member_status', 'create')
            ->notEmptyString('member_status');

        $validator
            ->integer('account_level')
            ->requirePresence('account_level', 'create')
            ->notEmptyString('account_level');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->existsIn(['clan_id'], 'Clans'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
