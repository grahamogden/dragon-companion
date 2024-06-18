<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Role;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roles Model
 *
 * @property \App\Model\Table\CampaignsTable&\Cake\ORM\Association\BelongsTo $Campaigns
 * @property \App\Model\Table\CharactersTable&\Cake\ORM\Association\BelongsToMany $Characters
 * @property \App\Model\Table\CombatEncountersTable&\Cake\ORM\Association\BelongsToMany $CombatEncounters
 * @property \App\Model\Table\SpeciesTable&\Cake\ORM\Association\BelongsToMany $Species
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @property \App\Model\Table\TimelinesTable&\Cake\ORM\Association\BelongsToMany $Timelines
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Role newEmptyEntity()
 * @method \App\Model\Entity\Role newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Role> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Role get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Role findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Role> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Role|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Role saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role> deleteManyOrFail(iterable $entities, array $options = [])
 */
class RolesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('roles');
        $this->setDisplayField('role_name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Campaigns', [
            'foreignKey' => 'campaign_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Characters', [
            'foreignKey' => 'role_id',
            'targetForeignKey' => 'character_id',
            'joinTable' => 'characters_roles',
        ]);
        $this->belongsToMany('CombatEncounters', [
            'foreignKey' => 'role_id',
            'targetForeignKey' => 'combat_encounter_id',
            'joinTable' => 'combat_encounters_roles',
        ]);
        $this->belongsToMany('Species', [
            'foreignKey' => 'role_id',
            'targetForeignKey' => 'species_id',
            'joinTable' => 'roles_species',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'role_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'roles_tags',
        ]);
        $this->belongsToMany('Timelines', [
            'foreignKey' => 'role_id',
            'targetForeignKey' => 'timeline_id',
            'joinTable' => 'roles_timelines',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'role_id',
            'targetForeignKey' => 'user_id',
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
            ->scalar('role_name')
            ->maxLength('role_name', 255)
            ->notEmptyString('role_name');

        $validator
            ->nonNegativeInteger('campaign_id')
            ->notEmptyString('campaign_id');

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
        $rules->add($rules->existsIn(['campaign_id'], 'Campaigns'), ['errorField' => 'campaign_id']);

        return $rules;
    }

    public function findByCampaignId(int $campaignId): array
    {
        $query = $this->find()
            ->where([Role::FIELD_CAMPAIGN_ID => $campaignId]);

        return $query->all()->toList();
    }
}
