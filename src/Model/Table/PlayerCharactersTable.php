<?php
namespace App\Model\Table;

use App\Model\Entity\PlayerCharacter;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlayerCharacters Model
 *
 * @property UsersTable&BelongsTo                $Users
 * @property CampaignsTable&BelongsTo            $Campaigns
 * @property CharacterClassesTable&BelongsToMany $CharacterClasses
 * @property CharacterRacesTable&BelongsToMany   $CharacterRaces
 * @property ParticipantsTable&BelongsToMany     $Participants
 *
 * @method PlayerCharacter get($primaryKey, $options = [])
 * @method PlayerCharacter newEntity($data = null, array $options = [])
 * @method PlayerCharacter[] newEntities(array $data, array $options = [])
 * @method PlayerCharacter|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method PlayerCharacter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method PlayerCharacter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method PlayerCharacter[] patchEntities($entities, array $data, array $options = [])
 * @method PlayerCharacter findOrCreate($search, callable $callback = null, $options = [])
 */
class PlayerCharactersTable extends Table
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

        $this->setTable('player_characters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Campaigns', [
            'foreignKey' => 'campaign_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('CharacterClasses', [
            'foreignKey' => 'player_character_id',
            'targetForeignKey' => 'character_class_id',
            'joinTable' => 'character_classes_player_characters',
        ]);
        $this->belongsToMany('CharacterRaces', [
            'foreignKey' => 'player_character_id',
            'targetForeignKey' => 'character_race_id',
            'joinTable' => 'character_races_player_characters',
        ]);
        $this->belongsToMany('Participants', [
            'foreignKey' => 'player_character_id',
            'targetForeignKey' => 'participant_id',
            'joinTable' => 'participants_player_characters',
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
            ->scalar('first_name')
            ->maxLength('first_name', 250)
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 250)
            ->notEmptyString('last_name');

        $validator
            ->integer('age')
            ->requirePresence('age', 'create')
            ->notEmptyString('age');

        $validator
            ->nonNegativeInteger('max_hit_points')
            ->requirePresence('max_hit_points', 'create')
            ->notEmptyString('max_hit_points');

        $validator
            ->nonNegativeInteger('armour_class')
            ->requirePresence('armour_class', 'create')
            ->notEmptyString('armour_class');

        $validator
            ->requirePresence('dexterity_modifier', 'create')
            ->notEmptyString('dexterity_modifier');

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
        $rules->add($rules->existsIn(['campaign_id'], 'Campaigns'));

        return $rules;
    }
}
