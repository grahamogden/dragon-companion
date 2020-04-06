<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CharacterClassesPlayerCharacters Model
 *
 * @property \App\Model\Table\CharacterClassesTable|\Cake\ORM\Association\BelongsTo $CharacterClasses
 * @property \App\Model\Table\PlayerCharactersTable|\Cake\ORM\Association\BelongsTo $PlayerCharacters
 *
 * @method \App\Model\Entity\CharacterClassesPlayerCharacter get($primaryKey, $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayerCharacter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayerCharacter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayerCharacter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayerCharacter|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayerCharacter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayerCharacter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterClassesPlayerCharacter findOrCreate($search, callable $callback = null, $options = [])
 */
class CharacterClassesPlayerCharactersTable extends Table
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

        $this->setTable('character_classes_player_characters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CharacterClasses', [
            'foreignKey' => 'character_class_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PlayerCharacters', [
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
        $rules->add($rules->existsIn(['player_character_id'], 'PlayerCharacters'));

        return $rules;
    }
}
