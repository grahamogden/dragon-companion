<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Role;
use App\Model\Entity\Timeline;
use App\Model\Entity\TimelinePermission;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TimelinePermissions Model
 *
 * @property \App\Model\Table\TimelinesTable&\Cake\ORM\Association\BelongsTo $Timeline
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\TimelinePermission newEmptyEntity()
 * @method \App\Model\Entity\TimelinePermission newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TimelinePermission> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TimelinePermission get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TimelinePermission findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TimelinePermission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TimelinePermission> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TimelinePermission|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TimelinePermission saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TimelinePermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TimelinePermission>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TimelinePermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TimelinePermission> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TimelinePermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TimelinePermission>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TimelinePermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TimelinePermission> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TimelinePermissionsTable extends Table
{
    public const TABLE_NAME = 'timeline_permissions';

    public const FIELD_TIMELINE_ID = 'timeline_id';
    public const FIELD_ROLE_ID = 'role_id';

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

        $this->belongsTo(Timeline::ENTITY_NAME, [
            'foreignKey' => 'timeline_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo(Role::ENTITY_NAME, [
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
            ->nonNegativeInteger(self::FIELD_TIMELINE_ID)
            ->notEmptyString(self::FIELD_TIMELINE_ID);

        $validator
            ->nonNegativeInteger(self::FIELD_ROLE_ID)
            ->notEmptyString(self::FIELD_ROLE_ID);

        // NEED TO ADD PERMISSIONS FIELD CHECK TO MAKE SURE THAT IT MATCHES THE ENUM

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
        $rules->add($rules->existsIn([self::FIELD_TIMELINE_ID], 'Timeline'), ['errorField' => self::FIELD_TIMELINE_ID]);
        $rules->add($rules->existsIn([self::FIELD_ROLE_ID], 'Roles'), ['errorField' => self::FIELD_ROLE_ID]);

        return $rules;
    }
}
