<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Campaign;
use App\Model\Entity\Character;
use App\Model\Entity\CharacterPermission;
use App\Model\Entity\Participant;
use App\Model\Entity\Role;
use App\Model\Entity\Species;
use App\Model\Entity\User;
use App\Services\TablePermissionsHelper\TablePermissionsHelper;
use Authorization\Identity;
use Cake\Datasource\QueryInterface;
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

    private readonly TablePermissionsHelper $tablePermissionsHelper;

    public function __construct(array $config)
    {
        parent::__construct(config: $config);
        $this->tablePermissionsHelper = new TablePermissionsHelper();
    }

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
        $this->hasMany(CharacterPermission::ENTITY_NAME, [
            'foreignKey' => CharacterPermission::FIELD_CHARACTER_ID,
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
            ->requirePresence(Character::FIELD_USER_ID, 'create')
            ->nonNegativeInteger(Character::FIELD_USER_ID)
            ->notEmptyString(Character::FIELD_USER_ID);

        $validator
            ->requirePresence(Character::FIELD_CAMPAIGN_ID, 'create')
            ->nonNegativeInteger(Character::FIELD_CAMPAIGN_ID)
            ->notEmptyString(Character::FIELD_CAMPAIGN_ID);

        $validator
            ->nonNegativeInteger(Character::FIELD_SPECIES_ID)
            ->notEmptyString(Character::FIELD_SPECIES_ID);

        $validator
            ->scalar(Character::FIELD_NAME)
            ->maxLength(Character::FIELD_NAME, 250)
            ->notEmptyString(Character::FIELD_NAME);

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

    public function findByIdAndCampaignId(int $campaignId, int $id): ?Character
    {
        $query = $this->find()
            ->where([
                Character::ENTITY_NAME . '.' . Character::FIELD_ID => $id,
                Character::ENTITY_NAME . '.' . Character::FIELD_CAMPAIGN_ID => $campaignId,
            ])
            ->contain([CharacterPermission::ENTITY_NAME, Species::ENTITY_NAME]);

        return $query->first();
    }

    public function findByCampaignIdWithPermissionsCheck(Identity $identity, int $campaignId): QueryInterface
    {
        $role = $this->tablePermissionsHelper->getUserRoleForCampaignOrThrowUnauthorizedError(
            identity: $identity,
            campaignId: $campaignId,
        );

        $query = $this->tablePermissionsHelper->addReadPermissionsChecksToQuery(
            query: $this->find()
                ->where([Character::ENTITY_NAME . '.' . Character::FIELD_CAMPAIGN_ID => $campaignId])
                ->contain([CharacterPermission::ENTITY_NAME]),
            permissionEntityName: CharacterPermission::ENTITY_NAME,
            role: $role,
        );

        return $query;
    }
}
