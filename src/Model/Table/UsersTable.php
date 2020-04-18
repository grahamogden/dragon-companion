<?php

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property CampaignsTable&HasMany             $Campaigns
 * @property ClansTable&HasMany&BelongsToMany   $Clans
 * @property CombatEncountersTable&HasMany      $CombatEncounters
 * @property MonstersTable&HasMany              $Monsters
 * @property NonPlayableCharactersTable&HasMany $NonPlayableCharacters
 * @property PlayerCharactersTable&HasMany      $PlayerCharacters
 * @property PuzzlesTable&HasMany               $Puzzles
 * @property TagsTable&HasMany                  $Tags
 * @property TimelineSegmentsTable&HasMany      $TimelineSegments
 *
 * @method User get($primaryKey, $options = [])
 * @method User newEntity($data = null, array $options = [])
 * @method User[] newEntities(array $data, array $options = [])
 * @method User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method User[] patchEntities($entities, array $data, array $options = [])
 * @method User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany(
            'Campaigns',
            [
                'foreignKey' => 'user_id',
            ]
        );
        $this->hasMany(
            'Clans',
            [
                'foreignKey' => 'user_id',
            ]
        );
        $this->hasMany(
            'CombatEncounters',
            [
                'foreignKey' => 'user_id',
            ]
        );
        $this->hasMany(
            'Monsters',
            [
                'foreignKey' => 'user_id',
            ]
        );
        $this->hasMany(
            'NonPlayableCharacters',
            [
                'foreignKey' => 'user_id',
            ]
        );
        $this->hasMany(
            'PlayerCharacters',
            [
                'foreignKey' => 'user_id',
            ]
        );
        $this->hasMany(
            'Puzzles',
            [
                'foreignKey' => 'user_id',
            ]
        );
        $this->hasMany(
            'Tags',
            [
                'foreignKey' => 'user_id',
            ]
        );
        $this->hasMany(
            'TimelineSegments',
            [
                'foreignKey' => 'user_id',
            ]
        );
        $this->belongsToMany(
            'Clans',
            [
//                'foreignKey'       => 'user_id',
//                'targetForeignKey' => 'clan_id',
                'through'        => 'ClansUsers',
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->notEmptyString('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

//        $validator
//            ->email('email')
//            ->notEmptyString('email');

        $validator
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     *
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
