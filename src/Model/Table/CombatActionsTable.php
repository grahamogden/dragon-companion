<?php

namespace App\Model\Table;

use App\Model\Entity\CombatAction;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CombatActions Model
 *
 * @property CombatTurnsTable&HasMany $CombatTurns
 *
 * @method CombatAction get($primaryKey, $options = [])
 * @method CombatAction newEntity($data = null, array $options = [])
 * @method CombatAction[] newEntities(array $data, array $options = [])
 * @method CombatAction|false save(EntityInterface $entity, $options = [])
 * @method CombatAction saveOrFail(EntityInterface $entity, $options = [])
 * @method CombatAction patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CombatAction[] patchEntities($entities, array $data, array $options = [])
 * @method CombatAction findOrCreate($search, callable $callback = null, $options = [])
 */
class CombatActionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('combat_actions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany(
            'CombatTurns',
            [
                'foreignKey' => 'combat_action_id',
            ]
        );
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     *
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        return $validator;
    }
}
