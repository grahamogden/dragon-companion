<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\MonsterPermission;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MonstersRoles Model
 *
 * @property \App\Model\Table\MonstersTable&\Cake\ORM\Association\BelongsTo $Monsters
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\MonstersRole newEmptyEntity()
 * @method \App\Model\Entity\MonstersRole newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\MonstersRole> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MonstersRole get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\MonstersRole findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\MonstersRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\MonstersRole> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MonstersRole|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\MonstersRole saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\MonstersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MonstersRole>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MonstersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MonstersRole> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MonstersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MonstersRole>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MonstersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MonstersRole> deleteManyOrFail(iterable $entities, array $options = [])
 */
class MonsterPermissionsTable extends Table
{
    public const TABLE_NAME = 'monster_permissions';
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
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Monsters', [
            'foreignKey' => MonsterPermission::FIELD_MONSTER_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => MonsterPermission::FIELD_ROLE_ID,
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
            ->nonNegativeInteger(MonsterPermission::FIELD_MONSTER_ID)
            ->notEmptyString(MonsterPermission::FIELD_MONSTER_ID);

        $validator
            ->nonNegativeInteger(MonsterPermission::FIELD_ROLE_ID)
            ->notEmptyString(MonsterPermission::FIELD_ROLE_ID);

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
        $rules->add($rules->existsIn([MonsterPermission::FIELD_MONSTER_ID], 'Monsters'), ['errorField' => MonsterPermission::FIELD_MONSTER_ID]);
        $rules->add($rules->existsIn([MonsterPermission::FIELD_ROLE_ID], 'Roles'), ['errorField' => MonsterPermission::FIELD_ROLE_ID]);

        return $rules;
    }
}
