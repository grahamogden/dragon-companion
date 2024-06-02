<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RolesTimelines Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\TimelinesTable&\Cake\ORM\Association\BelongsTo $Timelines
 *
 * @method \App\Model\Entity\RolesTimeline newEmptyEntity()
 * @method \App\Model\Entity\RolesTimeline newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RolesTimeline> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RolesTimeline get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RolesTimeline findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RolesTimeline patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RolesTimeline> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RolesTimeline|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RolesTimeline saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RolesTimeline>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RolesTimeline>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RolesTimeline>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RolesTimeline> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RolesTimeline>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RolesTimeline>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RolesTimeline>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RolesTimeline> deleteManyOrFail(iterable $entities, array $options = [])
 */
class RolesTimelinesTable extends Table
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

        $this->setTable('roles_timelines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Timelines', [
            'foreignKey' => 'timeline_id',
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
            ->nonNegativeInteger('timeline_id')
            ->notEmptyString('timeline_id');

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
        $rules->add($rules->existsIn(['timeline_id'], 'Timelines'), ['errorField' => 'timeline_id']);

        return $rules;
    }
}
