<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Participants Model
 *
 * @property \App\Model\Table\PlayerCharactersTable|\Cake\ORM\Association\BelongsTo $PlayerCharacters
 * @property \App\Model\Table\MonsterInstancesTable|\Cake\ORM\Association\BelongsTo $MonsterInstances
 *
 * @method \App\Model\Entity\Participant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Participant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Participant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Participant|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participant|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Participant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Participant findOrCreate($search, callable $callback = null, $options = [])
 */
class ParticipantsTable extends Table
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

        $this->setTable('participants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlayerCharacters', [
            'foreignKey' => 'player_character_id'
        ]);
        $this->belongsTo('MonsterInstances', [
            'foreignKey' => 'monster_instance_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('order')
            ->requirePresence('order', 'create')
            ->notEmpty('order');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['player_character_id'], 'PlayerCharacters'));
        $rules->add($rules->existsIn(['monster_instance_id'], 'MonsterInstances'));

        return $rules;
    }
}
