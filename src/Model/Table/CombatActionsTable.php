<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CombatActions Model
 *
 * @property \App\Model\Table\CombatTurnsTable&\Cake\ORM\Association\HasMany $CombatTurns
 *
 * @method \App\Model\Entity\CombatAction get($primaryKey, $options = [])
 * @method \App\Model\Entity\CombatAction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CombatAction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CombatAction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CombatAction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CombatAction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CombatAction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CombatAction findOrCreate($search, callable $callback = null, $options = [])
 */
class CombatActionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('combat_actions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('CombatTurns', [
            'foreignKey' => 'combat_action_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
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
