<?php

namespace App\Model\Table;

use App\Model\Entity\Monster;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Monsters Model
 *
 * @property UsersTable&BelongsTo            $Users
 * @property DataSourcesTable&BelongsTo      $DataSources
 * @property ParticipantsTable&BelongsToMany $Participants
 *
 * @method Monster get($primaryKey, $options = [])
 * @method Monster newEntity($data = null, array $options = [])
 * @method Monster[] newEntities(array $data, array $options = [])
 * @method Monster|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method Monster saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method Monster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method Monster[] patchEntities($entities, array $data, array $options = [])
 * @method Monster findOrCreate($search, callable $callback = null, $options = [])
 */
class MonstersTable extends Table
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

        $this->setTable('monsters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo(
            'Users',
            [
                'foreignKey' => 'user_id',
                'joinType'   => 'INNER',
            ]
        );
        $this->belongsTo(
            'DataSources',
            [
                'foreignKey' => 'data_source_id',
                'joinType'   => 'INNER',
            ]
        );
        $this->belongsToMany(
            'Participants',
            [
                'foreignKey'       => 'monster_id',
                'targetForeignKey' => 'participant_id',
                'joinTable'        => 'monsters_participants',
            ]
        );
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     *
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

        $validator
            ->integer('dexterity_modifier')
            ->requirePresence('dexterity_modifier', 'create')
            ->notEmptyString('dexterity_modifier');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     *
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['data_source_id'], 'DataSources'));

        return $rules;
    }
}
