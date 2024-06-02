<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Characters Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CampaignsTable&\Cake\ORM\Association\BelongsTo $Campaigns
 * @property \App\Model\Table\ParticipantsTable&\Cake\ORM\Association\HasMany $Participants
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsToMany $Roles
 * @property \App\Model\Table\SpeciesTable&\Cake\ORM\Association\BelongsToMany $Species
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
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('characters');
        $this->setDisplayField('first_name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Campaigns', [
            'foreignKey' => 'campaign_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Participants', [
            'foreignKey' => 'character_id',
        ]);
        $this->belongsToMany('Roles', [
            'foreignKey' => 'character_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'characters_roles',
        ]);
        $this->belongsToMany('Species', [
            'foreignKey' => 'character_id',
            'targetForeignKey' => 'species_id',
            'joinTable' => 'characters_species',
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
            ->nonNegativeInteger('user_id')
            ->notEmptyString('user_id');

        $validator
            ->nonNegativeInteger('campaign_id')
            ->notEmptyString('campaign_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->notEmptyString('name');

        $validator
            ->integer('age')
            ->requirePresence('age', 'create')
            ->notEmptyString('age');

        $validator
            ->nonNegativeInteger('max_hit_points')
            ->requirePresence('max_hit_points', 'create')
            ->notEmptyString('max_hit_points');

        $validator
            ->requirePresence('armour_class', 'create')
            ->notEmptyString('armour_class');

        $validator
            ->requirePresence('dexterity_modifier', 'create')
            ->notEmptyString('dexterity_modifier');

        $validator
            ->scalar('notes')
            ->requirePresence('notes', 'create')
            ->notEmptyString('notes');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['campaign_id'], 'Campaigns'), ['errorField' => 'campaign_id']);

        return $rules;
    }
}
