<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CharacterRacesPlayableCharacters Model
 *
 * @property \App\Model\Table\CharacterRacesTable|\Cake\ORM\Association\BelongsTo $CharacterRaces
 * @property \App\Model\Table\PlayableCharactersTable|\Cake\ORM\Association\BelongsTo $PlayableCharacters
 *
 * @method \App\Model\Entity\CharacterRacesPlayableCharacter get($primaryKey, $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayableCharacter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayableCharacter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayableCharacter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayableCharacter|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayableCharacter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayableCharacter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayableCharacter findOrCreate($search, callable $callback = null, $options = [])
 */
class CharacterRacesPlayableCharactersTable extends Table
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

        $this->setTable('character_races_playable_characters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CharacterRaces', [
            'foreignKey' => 'character_race_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PlayableCharacters', [
            'foreignKey' => 'playable_character_id',
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
        $rules->add($rules->existsIn(['character_race_id'], 'CharacterRaces'));
        $rules->add($rules->existsIn(['playable_character_id'], 'PlayableCharacters'));

        return $rules;
    }
}
