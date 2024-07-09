<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CombatEncountersRoles Model
 *
 * @property \App\Model\Table\CombatEncountersTable&\Cake\ORM\Association\BelongsTo $CombatEncounters
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\CombatEncountersRole newEmptyEntity()
 * @method \App\Model\Entity\CombatEncountersRole newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CombatEncountersRole> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CombatEncountersRole get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CombatEncountersRole findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CombatEncountersRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CombatEncountersRole> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CombatEncountersRole|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CombatEncountersRole saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CombatEncountersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatEncountersRole>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CombatEncountersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatEncountersRole> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CombatEncountersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatEncountersRole>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CombatEncountersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CombatEncountersRole> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CombatEncountersRolesTable extends Table
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

        $this->setTable('combat_encounters_roles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CombatEncounters', [
            'foreignKey' => 'combat_encounter_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
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
            ->nonNegativeInteger('combat_encounter_id')
            ->notEmptyString('combat_encounter_id');

        $validator
            ->nonNegativeInteger('role_id')
            ->notEmptyString('role_id');

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
        $rules->add($rules->existsIn(['combat_encounter_id'], 'CombatEncounters'), ['errorField' => 'combat_encounter_id']);
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }
}
