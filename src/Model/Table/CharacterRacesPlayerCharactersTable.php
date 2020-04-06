<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CharacterRacesPlayerCharacters Model
 *
 * @property \App\Model\Table\CharacterRacesTable&\Cake\ORM\Association\BelongsTo $CharacterRaces
 * @property \App\Model\Table\PlayerCharactersTable&\Cake\ORM\Association\BelongsTo $PlayerCharacters
 *
 * @method \App\Model\Entity\CharacterRacesPlayerCharacter get($primaryKey, $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayerCharacter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayerCharacter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayerCharacter|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayerCharacter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayerCharacter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayerCharacter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterRacesPlayerCharacter findOrCreate($search, callable $callback = null, $options = [])
 */
class CharacterRacesPlayerCharactersTable extends Table
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

        $this->setTable('character_races_player_characters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CharacterRaces', [
            'foreignKey' => 'character_race_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PlayerCharacters', [
            'foreignKey' => 'player_character_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn(['player_character_id'], 'PlayerCharacters'));

        return $rules;
    }
}
