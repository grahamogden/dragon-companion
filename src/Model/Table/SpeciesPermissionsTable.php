<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\SpeciesPermission;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SpeciesPermissions Model
 *
 * @property \App\Model\Table\SpeciesTable&\Cake\ORM\Association\BelongsTo $Species
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\SpeciesPermission newEmptyEntity()
 * @method \App\Model\Entity\SpeciesPermission newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SpeciesPermission> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SpeciesPermission get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SpeciesPermission findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SpeciesPermission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SpeciesPermission> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SpeciesPermission|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SpeciesPermission saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SpeciesPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SpeciesPermission>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SpeciesPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SpeciesPermission> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SpeciesPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SpeciesPermission>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SpeciesPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SpeciesPermission> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SpeciesPermissionsTable extends Table
{
    public const TABLE_NAME = 'species_permissions';

    public const FIELD_SPECIES_ID = 'species_id';
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

        $this->belongsTo('Species', [
            'foreignKey' => 'species_id',
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
            ->nonNegativeInteger(self::FIELD_SPECIES_ID)
            ->notEmptyString(self::FIELD_SPECIES_ID);

        $validator
            ->nonNegativeInteger(self::FIELD_ROLE_ID)
            ->notEmptyString(self::FIELD_ROLE_ID);

        // $validator
        //     ->boolean(SpeciesPermission::FIELD_CAN_READ);

        // $validator
        //     ->boolean(SpeciesPermission::FIELD_CAN_WRITE);

        // $validator
        //     ->boolean(SpeciesPermission::FIELD_CAN_DELETE);

        // $validator
        //     ->boolean(SpeciesPermission::FIELD_CAN_PERMISSION);

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
        $rules->add($rules->existsIn([self::FIELD_SPECIES_ID], 'Species'), ['errorField' => self::FIELD_SPECIES_ID]);
        $rules->add($rules->existsIn([self::FIELD_ROLE_ID], 'Roles'), ['errorField' => self::FIELD_ROLE_ID]);

        return $rules;
    }
}
