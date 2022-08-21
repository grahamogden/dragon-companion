<?php

namespace App\Model\Table;

use App\Model\Entity\Monster;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Monsters Model
 *
 * @property UsersTable&BelongsTo                $Users
 * @property DataSourcesTable&BelongsTo          $DataSources
 * @property MonsterInstanceTypesTable&BelongsTo $MonsterInstanceTypes
 * @property AlignmentsTable&BelongsTo           $Alignments
 * @property ParticipantsTable&HasMany           $Participants
 *
 * @method Monster get($primaryKey, $options = [])
 * @method Monster newEntity($data = null, array $options = [])
 * @method Monster[] newEntities(array $data, array $options = [])
 * @method Monster|false save(EntityInterface $entity, $options = [])
 * @method Monster saveOrFail(EntityInterface $entity, $options = [])
 * @method Monster patchEntity(EntityInterface $entity, array $data, array $options = [])
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
    public function initialize(array $config): void
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
        $this->belongsTo(
            'MonsterInstanceTypes',
            [
                'foreignKey' => 'monster_instance_type_id',
            ]
        );
        $this->belongsTo(
            'Alignments',
            [
                'foreignKey' => 'alignment_id',
                'joinType'   => 'INNER',
            ]
        );
        $this->hasMany(
            'Participants',
            [
                'foreignKey' => 'monster_id',
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
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->notEmptyString('name');

        $validator
            ->scalar('source_location')
            ->maxLength('source_location', 500)
            ->allowEmptyString('source_location');

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
            ->integer('dexterity_modifier')
            ->requirePresence('dexterity_modifier', 'create')
            ->notEmptyString('dexterity_modifier');

        $validator
            ->scalar('visibility')
            ->notEmptyString('visibility')
            ->inList('visibility', array_keys(Monster::VISIBILITY_OPTIONS));

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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['data_source_id'], 'DataSources'));
        $rules->add($rules->existsIn(['monster_instance_type_id'], 'MonsterInstanceTypes'));
        $rules->add($rules->existsIn(['alignment_id'], 'Alignments'));

        return $rules;
    }
}
