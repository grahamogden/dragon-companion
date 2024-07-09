<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RolesTags Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\RolesTag newEmptyEntity()
 * @method \App\Model\Entity\RolesTag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RolesTag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RolesTag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RolesTag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RolesTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RolesTag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RolesTag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RolesTag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RolesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RolesTag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RolesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RolesTag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RolesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RolesTag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RolesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RolesTag> deleteManyOrFail(iterable $entities, array $options = [])
 */
class RolesTagsTable extends Table
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

        $this->setTable('roles_tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
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
            ->nonNegativeInteger('role_id')
            ->notEmptyString('role_id');

        $validator
            ->nonNegativeInteger('tag_id')
            ->notEmptyString('tag_id');

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
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => 'tag_id']);

        return $rules;
    }
}
