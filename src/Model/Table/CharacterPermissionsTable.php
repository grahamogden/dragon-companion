<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\CharacterPermission;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CharactersRoles Model
 *
 * @property \App\Model\Table\CharactersTable&\Cake\ORM\Association\BelongsTo $Characters
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\CharactersRole newEmptyEntity()
 * @method \App\Model\Entity\CharactersRole newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CharactersRole> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CharactersRole get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CharactersRole findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CharactersRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CharactersRole> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CharactersRole|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CharactersRole saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CharactersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CharactersRole>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CharactersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CharactersRole> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CharactersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CharactersRole>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CharactersRole>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CharactersRole> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CharacterPermissionsTable extends Table
{
    public const TABLE_NAME = 'character_permissions';
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

        $this->belongsTo('Characters', [
            'foreignKey' => CharacterPermission::FIELD_CHARACTER_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => CharacterPermission::FIELD_ROLE_ID,
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
            ->nonNegativeInteger(CharacterPermission::FIELD_CHARACTER_ID)
            ->notEmptyString(CharacterPermission::FIELD_CHARACTER_ID);

        $validator
            ->nonNegativeInteger(CharacterPermission::FIELD_ROLE_ID)
            ->notEmptyString(CharacterPermission::FIELD_ROLE_ID);

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
        $rules->add($rules->existsIn([CharacterPermission::FIELD_CHARACTER_ID], 'Characters'), ['errorField' => CharacterPermission::FIELD_CHARACTER_ID]);
        $rules->add($rules->existsIn([CharacterPermission::FIELD_ROLE_ID], 'Roles'), ['errorField' => CharacterPermission::FIELD_ROLE_ID]);

        return $rules;
    }
}
