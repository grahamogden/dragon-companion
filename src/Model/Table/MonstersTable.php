<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Monsters Model
 *
 * @property \App\Model\Table\DataSourcesTable&\Cake\ORM\Association\BelongsTo $DataSources
 * @property \App\Model\Table\ParticipantsTable&\Cake\ORM\Association\BelongsToMany $Participants
 *
 * @method \App\Model\Entity\Monster get($primaryKey, $options = [])
 * @method \App\Model\Entity\Monster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Monster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Monster|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Monster saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
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

        $this->belongsTo('DataSources', [
            'foreignKey' => 'data_source_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Participants', [
            'foreignKey' => 'monster_id',
            'targetForeignKey' => 'participant_id',
            'joinTable' => 'monsters_participants',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->notEmptyString('name');

        $validator
            ->numeric('max_hit_points')
            ->greaterThanOrEqual('max_hit_points', 0)
            ->requirePresence('max_hit_points', 'create')
            ->notEmptyString('max_hit_points');

        $validator
            ->nonNegativeInteger('armour_class')
            ->requirePresence('armour_class', 'create')
            ->notEmptyString('armour_class');

        $validator
            ->scalar('source_location')
            ->maxLength('source_location', 500)
            ->allowEmptyString('source_location');

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
        $rules->add($rules->existsIn(['data_source_id'], 'DataSources'));

        return $rules;
    }
}
