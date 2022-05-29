<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Query;
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
 * @property &\Cake\ORM\Association\HasMany $ZBackupTimelineSegments2020-04-10
 * @property &\Cake\ORM\Association\HasMany $ZBackupTimelineSegmentsCopy
 * @property &\Cake\ORM\Association\HasMany $ZBackupTimelineSegmentsCopy2
 *
 // * @method User get($primaryKey, $options = [])
 // * @method User newEntity($data = null, array $options = [])
 // * @method User[] newEntities(array $data, array $options = [])
 // * @method User|false save(EntityInterface $entity, $options = [])
 // * @method User saveOrFail(EntityInterface $entity, $options = [])
 // * @method User patchEntity(EntityInterface $entity, array $data, array $options = [])
 // * @method User[] patchEntities($entities, array $data, array $options = [])
 // * @method User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
{
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
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
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
    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
