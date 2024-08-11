<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\ItemPermission;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemPermissions Model
 *
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Item
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\ItemPermission newEmptyEntity()
 * @method \App\Model\Entity\ItemPermission newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ItemPermission> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemPermission get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ItemPermission findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ItemPermission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ItemPermission> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemPermission|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ItemPermission saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ItemPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ItemPermission>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ItemPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ItemPermission> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ItemPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ItemPermission>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ItemPermission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ItemPermission> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ItemPermissionsTable extends Table
{
    public const TABLE_NAME = 'item_permissions';

    public const FIELD_Item_ID = 'item_id';
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

        $this->belongsTo('Item', [
            'foreignKey' => 'item_id',
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
            ->nonNegativeInteger(self::FIELD_Item_ID)
            ->notEmptyString(self::FIELD_Item_ID);

        $validator
            ->nonNegativeInteger(self::FIELD_ROLE_ID)
            ->notEmptyString(self::FIELD_ROLE_ID);

        // NEED TO ADD PERMISSIONS FIELD CHECK TO MAKE SURE THAT IT MATCHES THE ENUM

        return $validator;
    }

    /**
     * Returns a rules checker item that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules item to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn([self::FIELD_Item_ID], 'Item'), ['errorField' => self::FIELD_Item_ID]);
        $rules->add($rules->existsIn([self::FIELD_ROLE_ID], 'Roles'), ['errorField' => self::FIELD_ROLE_ID]);

        return $rules;
    }
}
