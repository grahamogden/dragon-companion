<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Conditions Model
 *
 * @property \App\Model\Table\CombatTurnsTable&\Cake\ORM\Association\HasMany $CombatTurns
 * @property \App\Model\Table\ParticipantsTable&\Cake\ORM\Association\BelongsToMany $Participants
 *
 * @method \App\Model\Entity\Condition get($primaryKey, $options = [])
 * @method \App\Model\Entity\Condition newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Condition[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Condition|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Condition saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Condition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Condition[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Condition findOrCreate($search, callable $callback = null, $options = [])
 */
class ConditionsTable extends Table
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

        $this->setTable('conditions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('CombatTurns', [
            'foreignKey' => 'condition_id',
        ]);
        $this->belongsToMany('Participants', [
            'foreignKey' => 'condition_id',
            'targetForeignKey' => 'participant_id',
            'joinTable' => 'conditions_participants',
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
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->notEmptyString('description');

        return $validator;
    }
}
