<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Campaign;
use App\Model\Entity\Character;
use App\Model\Entity\CharactersRole;
use App\Model\Entity\Participant;
use App\Model\Entity\Role;
use App\Model\Entity\Species;
use App\Model\Entity\User;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Characters Model
 *
 * @property UsersTable&BelongsTo $Users
 * @property CampaignsTable&BelongsTo $Campaigns
 * @property ParticipantsTable&HasMany $Participants
 * @property RolesTable&BelongsToMany $Roles
 * @property SpeciesTable&BelongsTo $Species
 *
 * @method \App\Model\Entity\Character newEmptyEntity()
 * @method \App\Model\Entity\Character newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Character> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Character get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Character findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Character patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Character> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Character|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Character saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Character>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Character>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Character>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Character> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Character>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Character>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Character>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Character> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CharactersTable extends Table
{
    public const TABLE_NAME = 'characters';

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
        $this->setDisplayField(Character::FIELD_NAME);
        $this->setPrimaryKey('id');

        $this->belongsTo(User::ENTITY_NAME, [
            'foreignKey' => Character::FIELD_USER_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsTo(Campaign::ENTITY_NAME, [
            'foreignKey' => Character::FIELD_CAMPAIGN_ID,
            'joinType' => 'INNER',
        ]);
        $this->hasMany(Participant::ENTITY_NAME, [
            'foreignKey' => Participant::FIELD_CHARACTER_ID,
        ]);
        $this->belongsTo(Species::ENTITY_NAME, [
            'foreignKey' => Character::FIELD_SPECIES_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany(Role::ENTITY_NAME, [
            'foreignKey' => 'character_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => CharactersRolesTable::TABLE_NAME,
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
            ->nonNegativeInteger(Character::FIELD_USER_ID)
            ->notEmptyString(Character::FIELD_USER_ID);

        $validator
            ->nonNegativeInteger(Character::FIELD_CAMPAIGN_ID)
            ->notEmptyString(Character::FIELD_CAMPAIGN_ID);

        $validator
            ->nonNegativeInteger(Character::FIELD_SPECIES_ID)
            ->notEmptyString(Character::FIELD_SPECIES_ID);

        $validator
            ->scalar(Character::FIELD_NAME)
            ->maxLength(Character::FIELD_NAME, 250)
            ->notEmptyString(Character::FIELD_NAME);

        $validator
            ->integer(Character::FIELD_AGE)
            ->requirePresence(Character::FIELD_AGE, 'create')
            ->notEmptyString(Character::FIELD_AGE);

        $validator
            ->nonNegativeInteger(Character::FIELD_MAX_HIT_POINTS)
            ->requirePresence(Character::FIELD_MAX_HIT_POINTS, 'create')
            ->notEmptyString(Character::FIELD_MAX_HIT_POINTS);

        $validator
            ->requirePresence(Character::FIELD_ARMOUR_CLASS, 'create')
            ->notEmptyString(Character::FIELD_ARMOUR_CLASS);

        $validator
            ->requirePresence(Character::FIELD_DEXTERITY_MODIFIER, 'create')
            ->notEmptyString(Character::FIELD_DEXTERITY_MODIFIER);

        $validator
            ->scalar(Character::FIELD_NOTES)
            ->requirePresence(Character::FIELD_NOTES, 'create')
            ->notEmptyString(Character::FIELD_NOTES);

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
        $rules->add($rules->existsIn([Character::FIELD_USER_ID], User::ENTITY_NAME), ['errorField' => Character::FIELD_USER_ID]);
        $rules->add($rules->existsIn([Character::FIELD_CAMPAIGN_ID], Campaign::ENTITY_NAME), ['errorField' => Character::FIELD_CAMPAIGN_ID]);
        $rules->add($rules->existsIn([Character::FIELD_SPECIES_ID], Species::ENTITY_NAME), ['errorField' => Character::FIELD_SPECIES_ID]);

        return $rules;
    }
}
