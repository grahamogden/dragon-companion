<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DataSources Model
 *
 * @property \App\Model\Table\MonstersTable&\Cake\ORM\Association\HasMany $Monsters
 *
 * @method \App\Model\Entity\DataSource get($primaryKey, $options = [])
 * @method \App\Model\Entity\DataSource newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DataSource[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DataSource|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DataSource saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DataSource patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DataSource[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DataSource findOrCreate($search, callable $callback = null, $options = [])
 */
class DataSourcesTable extends Table
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

        $this->setTable('data_sources');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Monsters', [
            'foreignKey' => 'data_source_id',
        ]);
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
            ->scalar('name')
            ->maxLength('name', 250)
            ->notEmptyString('name');

        return $validator;
    }
}
