<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlayableCharacters Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ParticipantsTable|\Cake\ORM\Association\HasMany $Participants
 * @property \App\Model\Table\CharacterClassesTable|\Cake\ORM\Association\BelongsToMany $CharacterClasses
 * @property \App\Model\Table\CharacterRacesTable|\Cake\ORM\Association\BelongsToMany $CharacterRaces
 *
 * @method \App\Model\Entity\PlayableCharacter get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlayableCharacter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlayableCharacter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlayableCharacter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlayableCharacter|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlayableCharacter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlayableCharacter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlayableCharacter findOrCreate($search, callable $callback = null, $options = [])
 */
class PlayableCharactersTable extends Table
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

        $this->setTable('playable_characters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Participants', [
            'foreignKey' => 'playable_character_id'
        ]);
        $this->belongsToMany('CharacterClasses', [
            'foreignKey' => 'playable_character_id',
            'targetForeignKey' => 'character_class_id',
            'joinTable' => 'character_classes_playable_characters'
        ]);
        $this->belongsToMany('CharacterRaces', [
            'foreignKey' => 'playable_character_id',
            'targetForeignKey' => 'character_race_id',
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
            ->scalar('first_name')
            ->maxLength('first_name', 250)
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 250)
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->integer('age')
            ->requirePresence('age', 'create')
            ->notEmpty('age');

        $validator
            ->integer('max_hp')
            ->requirePresence('max_hp', 'create')
            ->notEmpty('max_hp');

        $validator
            ->integer('current_hp')
            ->requirePresence('current_hp', 'create')
            ->notEmpty('current_hp');

        $validator
            ->integer('armour_class')
            ->requirePresence('armour_class', 'create')
            ->notEmpty('armour_class');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
