<?php

namespace App\Model\Table;

use App\Model\Entity\Alignment;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Alignments Model
 *
 * @property MonstersTable&HasMany              $Monsters
 * @property NonPlayableCharactersTable&HasMany $NonPlayableCharacters
 * @property PlayerCharactersTable&HasMany      $PlayerCharacters
 *
 * @method Alignment get($primaryKey, $options = [])
 * @method Alignment newEntity($data = null, array $options = [])
 * @method Alignment[] newEntities(array $data, array $options = [])
 * @method Alignment|false save(EntityInterface $entity, $options = [])
 * @method Alignment saveOrFail(EntityInterface $entity, $options = [])
 * @method Alignment patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Alignment[] patchEntities($entities, array $data, array $options = [])
 * @method Alignment findOrCreate($search, callable $callback = null, $options = [])
 */
class AlignmentsTable extends Table
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

        $this->setTable('alignments');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany(
            'Monsters',
            [
                'foreignKey' => 'alignment_id',
            ]
        );
        $this->hasMany(
            'NonPlayableCharacters',
            [
                'foreignKey' => 'alignment_id',
            ]
        );
        $this->hasMany(
            'PlayerCharacters',
            [
                'foreignKey' => 'alignment_id',
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
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        return $validator;
    }
}
