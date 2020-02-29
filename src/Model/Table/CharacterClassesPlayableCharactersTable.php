<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CharacterClassesPlayableCharacters Model
 *
 * @property \App\Model\Table\CharacterClassesTable|\Cake\ORM\Association\BelongsTo $CharacterClasses
 * @property \App\Model\Table\PlayableCharactersTable|\Cake\ORM\Association\BelongsTo $PlayableCharacters
 *
 * @method \App\Model\Entity\CharacterClassesPlayableCharacter get($primaryKey, $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayableCharacter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayableCharacter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayableCharacter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayableCharacter|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayableCharacter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayableCharacter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayableCharacter findOrCreate($search, callable $callback = null, $options = [])
 */
class CharacterClassesPlayableCharactersTable extends Table
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

        $this->setTable('character_classes_playable_characters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CharacterClasses', [
            'foreignKey' => 'character_class_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PlayableCharacters', [
            'foreignKey' => 'player_character_id',
            'joinType' => 'INNER'
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['character_class_id'], 'CharacterClasses'));
        $rules->add($rules->existsIn(['player_character_id'], 'PlayableCharacters'));

        return $rules;
    }
}
