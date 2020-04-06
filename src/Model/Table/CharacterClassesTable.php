<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CharacterClasses Model
 *
 * @property \App\Model\Table\PlayerCharactersTable&\Cake\ORM\Association\BelongsToMany $PlayerCharacters
 *
 * @method \App\Model\Entity\CharacterClass get($primaryKey, $options = [])
 * @method \App\Model\Entity\CharacterClass newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CharacterClass[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClass|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterClass saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterClass patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClass[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClass findOrCreate($search, callable $callback = null, $options = [])
 */
class CharacterClassesTable extends Table
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

        $this->setTable('character_classes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('PlayerCharacters', [
            'foreignKey' => 'character_class_id',
            'targetForeignKey' => 'player_character_id',
            'joinTable' => 'character_classes_player_characters',
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
            ->maxLength('name', 25)
            ->notEmptyString('name');

        return $validator;
    }
}
