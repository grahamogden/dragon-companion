<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CharacterClasses Model
 *
 * @property \App\Model\Table\PlayableCharactersTable|\Cake\ORM\Association\BelongsToMany $PlayableCharacters
 *
 * @method \App\Model\Entity\CharacterClass get($primaryKey, $options = [])
 * @method \App\Model\Entity\CharacterClass newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CharacterClass[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClass|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterClass|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
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
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('PlayableCharacters', [
            'foreignKey' => 'character_class_id',
            'targetForeignKey' => 'playable_character_id',
            'joinTable' => 'character_classes_playable_characters'
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

        return $validator;
    }
}
