<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Monsters Model
 *
 * @property \App\Model\Table\MonsterInstancesTable|\Cake\ORM\Association\HasMany $MonsterInstances
 *
 * @method \App\Model\Entity\Monster get($primaryKey, $options = [])
 * @method \App\Model\Entity\Monster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Monster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Monster|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Monster|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Monster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Monster[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Monster findOrCreate($search, callable $callback = null, $options = [])
 */
class MonstersTable extends Table
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

        $this->setTable('monsters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('MonsterInstances', [
            'foreignKey' => 'monster_id'
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
            ->allowEmpty('name');

        return $validator;
    }
}
