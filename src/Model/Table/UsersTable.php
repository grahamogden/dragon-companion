<?php

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\Database\Query\SelectQuery;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property CampaignsTable&HasMany             $CampaignUsers
 * @property ClansTable&HasMany                 $Clans
 * @property CombatEncountersTable&HasMany      $CombatEncounters
 * @property MonstersTable&HasMany              $Monsters
 * @property NonPlayableCharactersTable&HasMany $NonPlayableCharacters
 * @property PlayerCharactersTable&HasMany      $PlayerCharacters
 * @property PuzzlesTable&HasMany               $Puzzles
 * @property TagsTable&HasMany                  $Tags
 * @property TimelineSegmentsTable&HasMany      $TimelineSegments
 */
class UsersTable extends Table
{
    public const TABLE_NAME = 'Users';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CampaignUsers', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('CombatEncounters', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Monsters', [
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
        $this->belongsToMany('Campaigns', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'campaign_id',
            'joinTable' => 'campaign_users',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     *
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger(User::FIELD_ID)
            ->allowEmptyString(User::FIELD_ID, null, 'create');

        $validator
            ->scalar(User::FIELD_USERNAME)
            ->maxLength(User::FIELD_USERNAME, 255)
            ->notEmptyString(User::FIELD_USERNAME)
            ->add(User::FIELD_USERNAME, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        // $validator
        //     ->scalar('password')
        //     ->maxLength('password', 255)
        //     ->requirePresence('password', 'create')
        //     ->notEmptyString('password');

        //        $validator
        //            ->email('email')
        //            ->notEmptyString('email');

        $validator
            ->requirePresence(User::FIELD_STATUS, 'create')
            ->notEmptyString(User::FIELD_STATUS)
            ->inList(User::FIELD_STATUS, User::USER_STATUSES);

        $validator
            ->requirePresence(User::FIELD_EXTERNAL_USER_ID, 'create')
            ->notEmptyString(User::FIELD_EXTERNAL_USER_ID);

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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique([User::FIELD_USERNAME]));
        $rules->add($rules->isUnique([User::FIELD_EMAIL]));
        $rules->add($rules->isUnique([User::FIELD_EXTERNAL_USER_ID]));

        return $rules;
    }

    public function findByExternalUserId(string $externalUserId): User | null
    {
        /** @var User $user */
        $user = $this->find()
            ->where([User::FIELD_EXTERNAL_USER_ID => $externalUserId])
            ->first();

        return $user;
    }
}
