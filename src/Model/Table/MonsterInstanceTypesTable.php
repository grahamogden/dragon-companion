<?php

namespace App\Model\Table;

use App\Model\Entity\MonsterInstanceType;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MonsterInstanceTypes Model
 *
 * @property MonstersTable&HasMany $Monsters
 *
 * @method MonsterInstanceType get($primaryKey, $options = [])
 * @method MonsterInstanceType newEntity($data = null, array $options = [])
 * @method MonsterInstanceType[] newEntities(array $data, array $options = [])
 * @method MonsterInstanceType|false save(EntityInterface $entity, $options = [])
 * @method MonsterInstanceType saveOrFail(EntityInterface $entity, $options = [])
 * @method MonsterInstanceType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method MonsterInstanceType[] patchEntities($entities, array $data, array $options = [])
 * @method MonsterInstanceType findOrCreate($search, callable $callback = null, $options = [])
 */
class MonsterInstanceTypesTable extends Table
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

        $this->setTable('monster_instance_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany(
            'Monsters',
            [
                'foreignKey' => 'monster_instance_type_id',
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
            ->scalar('name')
            ->maxLength('name', 250)
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 1000)
            ->allowEmptyString('description');

        return $validator;
    }
}
