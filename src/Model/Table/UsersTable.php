<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\CombatEncountersTable&\Cake\ORM\Association\HasMany $CombatEncounters
 * @property \App\Model\Table\NonPlayableCharactersTable&\Cake\ORM\Association\HasMany $NonPlayableCharacters
 * @property \App\Model\Table\PlayerCharactersTable&\Cake\ORM\Association\HasMany $PlayerCharacters
 * @property \App\Model\Table\PuzzlesTable&\Cake\ORM\Association\HasMany $Puzzles
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\HasMany $Tags
 * @property \App\Model\Table\TimelineSegmentsTable&\Cake\ORM\Association\HasMany $TimelineSegments
 * @property &\Cake\ORM\Association\HasMany $TimelineSegmentsCopy
 * @property &\Cake\ORM\Association\HasMany $TimelineSegmentsCopy2
 * @property \App\Model\Table\ClansTable&\Cake\ORM\Association\BelongsToMany $Clans
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CombatEncounters', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('NonPlayableCharacters', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('PlayerCharacters', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Puzzles', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Tags', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('TimelineSegments', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsToMany('Clans', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'clan_id',
            'joinTable' => 'clans_users',
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
            ->scalar('username')
            ->maxLength('username', 255)
            ->notEmptyString('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        // $validator
        //     ->email('email')
        //     ->notEmptyString('email');

        // $validator
        //     ->email('email')
        //     ->requirePresence('email', 'create')
        //     ->notEmpty('email');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
