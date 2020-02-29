<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CharacterRaces Model
 *
 * @property \App\Model\Table\PlayableCharactersTable|\Cake\ORM\Association\BelongsToMany $PlayableCharacters
 *
 * @method \App\Model\Entity\CharacterRace get($primaryKey, $options = [])
 * @method \App\Model\Entity\CharacterRace newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CharacterRace[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CharacterRace|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterRace|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CharacterRace patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterRace[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CharacterRace findOrCreate($search, callable $callback = null, $options = [])
 */
class CharacterRacesTable extends Table
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

        $this->setTable('character_races');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('PlayableCharacters', [
            'foreignKey' => 'character_race_id',
            'targetForeignKey' => 'playable_character_id',
            'joinTable' => 'character_races_playable_characters'
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

        $validator
            ->scalar('name')
            ->maxLength('name', 25)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
