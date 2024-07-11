<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Species;
use App\Model\Entity\SpeciesPermission;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Species Model
 *
 * @property \App\Model\Table\CampaignsTable&\Cake\ORM\Association\BelongsTo $Campaigns
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CharactersTable&\Cake\ORM\Association\BelongsToMany $Characters
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsToMany $Roles
 * @property \App\Model\Table\SpeciesPermissionsTable&\Cake\ORM\Association\BelongsTo $SpeciesPermissions
 *
 * @method \App\Model\Entity\Species newEmptyEntity()
 * @method \App\Model\Entity\Species newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Species> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Species get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Species findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Species patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Species> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Species|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Species saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Species>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Species>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Species>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Species> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Species>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Species>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Species>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Species> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SpeciesTable extends Table
{
    public const TABLE_NAME = 'species';

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
        $this->setDisplayField(Species::FIELD_NAME);
        $this->setPrimaryKey('id');

        $this->belongsTo('Campaigns', [
            'foreignKey' => 'campaign_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        // $this->belongsToMany('Characters', [
        //     'foreignKey' => 'species_id',
        //     'joinType' => 'INNER',
        //     // 'targetForeignKey' => 'character_id',
        //     // 'joinTable' => 'characters_species',
        // ]);
        $this->hasMany('SpeciesPermissions', [
            'foreignKey' => 'species_id',
        ]);
        // $this->belongsToMany('Roles', [
        //     'foreignKey' => 'species_id',
        //     'targetForeignKey' => 'role_id',
        //     'joinTable' => 'roles_species',
        // ]);
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
            ->scalar(Species::FIELD_NAME)
            ->minLength(Species::FIELD_NAME, 3)
            ->maxLength(Species::FIELD_NAME, 255)
            ->requirePresence(Species::FIELD_NAME)
            ->notEmptyString(Species::FIELD_NAME);

        $validator
            ->nonNegativeInteger('campaign_id')
            ->notEmptyString('campaign_id');

        $validator
            ->nonNegativeInteger('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmptyString('user_id');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    public function findByIdAndCampaignId(int $id, int $campaignId): ?Species
    {
        $query = $this->find()
            ->where([
                Species::FIELD_ID => $id,
                Species::FIELD_CAMPAIGN_ID => $campaignId,
            ])
            ->contain([SpeciesPermission::ENTITY_NAME]);

        return $query->first();

        // $entity = $this->get($id);
        // dd($entity);
        // if ($entity->campaign_id === $campaignId) {
        //     return $entity;
        // }

        // return null;
    }

    /**
     * @return Species[]
     */
    public function findByCampaignId(int $campaignId): ?array
    {
        try {
            $query = $this->find()
                ->where([Species::FIELD_CAMPAIGN_ID => $campaignId])
                ->contain([SpeciesPermission::ENTITY_NAME]);

            return $query->all()->toList();
        } catch (RecordNotFoundException $exception) {
            return null;
        }
    }
}
