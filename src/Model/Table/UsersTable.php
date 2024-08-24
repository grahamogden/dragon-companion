<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Campaign;
use App\Model\Entity\Character;
use App\Model\Entity\CombatEncounter;
use App\Model\Entity\Role;
use App\Model\Entity\RolesUser;
use App\Model\Entity\Species;
use App\Model\Entity\Tag;
use App\Model\Entity\Timeline;
use App\Model\Entity\User;
use App\Model\Enum\UserStatus;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property CampaignsTable&HasMany $Campaigns
 * @property CharactersTable&HasMany $Characters
 * @property CombatEncountersTable&HasMany $CombatEncounters
 * @property SpeciesTable&HasMany $Species
 * @property TagsTable&HasMany $Tags
 * @property TimelinesTable&HasMany $Timelines
 * @property RolesTable&BelongsToMany $Roles
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\User> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    public const TABLE_NAME = 'users';

    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable(self::TABLE_NAME);
        $this->setDisplayField(User::ENTITY_NAME);
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Campaigns', [
            'foreignKey' => Campaign::FIELD_USER_ID,
        ]);
        $this->hasMany('Characters', [
            'foreignKey' => Character::FIELD_USER_ID,
        ]);
        $this->hasMany('CombatEncounters', [
            'foreignKey' => CombatEncounter::FIELD_USER_ID,
        ]);
        $this->hasMany('Species', [
            'foreignKey' => Species::FIELD_USER_ID,
        ]);
        $this->hasMany('Tags', [
            'foreignKey' => Tag::FIELD_USER_ID,
        ]);
        $this->hasMany('Timelines', [
            'foreignKey' => Timeline::FIELD_USER_ID,
        ]);
        $this->belongsToMany('Roles', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'roles_users',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar(User::FIELD_USERNAME)
            ->maxLength(User::FIELD_USERNAME, 255)
            ->notEmptyString(User::FIELD_USERNAME)
            ->add(User::FIELD_USERNAME, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->email(User::FIELD_EMAIL)
            ->notEmptyString(User::FIELD_EMAIL)
            ->add(User::FIELD_EMAIL, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence(User::FIELD_STATUS, 'create')
            ->notEmptyString(User::FIELD_STATUS)
            ->inList(User::FIELD_STATUS, UserStatus::getValues());

        $validator
            ->scalar(User::FIELD_EXTERNAL_USER_ID)
            ->maxLength(User::FIELD_EXTERNAL_USER_ID, 255)
            ->requirePresence(User::FIELD_EXTERNAL_USER_ID, 'create')
            ->notEmptyString(User::FIELD_EXTERNAL_USER_ID)
            ->add(User::FIELD_EXTERNAL_USER_ID, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique([User::FIELD_USERNAME]), ['errorField' => User::FIELD_USERNAME]);
        $rules->add($rules->isUnique([User::FIELD_EMAIL]), ['errorField' => User::FIELD_EMAIL]);
        $rules->add($rules->isUnique([User::FIELD_EXTERNAL_USER_ID]), ['errorField' => User::FIELD_EXTERNAL_USER_ID]);

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

    public function findAuth(Query $query, array $options): Query
    {
        return $query->contain([Role::ENTITY_NAME]);
    }
}
