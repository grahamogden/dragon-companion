<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MonsterInstances Model
 *
 * @property \App\Model\Table\MonstersTable|\Cake\ORM\Association\BelongsTo $Monsters
 * @property \App\Model\Table\ParticipantsTable|\Cake\ORM\Association\HasMany $Participants
 *
 * @method \App\Model\Entity\MonsterInstance get($primaryKey, $options = [])
 * @method \App\Model\Entity\MonsterInstance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MonsterInstance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MonsterInstance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MonsterInstance|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MonsterInstance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MonsterInstance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MonsterInstance findOrCreate($search, callable $callback = null, $options = [])
 */
class MonsterInstancesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('monster_instances');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Monsters', [
            'foreignKey' => 'monster_id'
        ]);
        $this->hasMany('Participants', [
            'foreignKey' => 'monster_instance_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('max_hp')
            ->requirePresence('max_hp', 'create')
            ->notEmpty('max_hp');

        $validator
            ->integer('current_hp')
            ->requirePresence('current_hp', 'create')
            ->notEmpty('current_hp');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['monster_id'], 'Monsters'));

        return $rules;
    }
}
