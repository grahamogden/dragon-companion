<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NonPlayableCharacters Model
 *
 * @property \App\Model\Table\TimelineSegmentsTable|\Cake\ORM\Association\BelongsToMany $TimelineSegments
 *
 * @method \App\Model\Entity\NonPlayableCharacter get($primaryKey, $options = [])
 * @method \App\Model\Entity\NonPlayableCharacter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NonPlayableCharacter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NonPlayableCharacter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NonPlayableCharacter|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NonPlayableCharacter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NonPlayableCharacter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NonPlayableCharacter findOrCreate($search, callable $callback = null, $options = [])
 */
class NonPlayableCharactersTable extends Table
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

        $this->setTable('non_playable_characters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('TimelineSegments', [
            'foreignKey' => 'non_playable_character_id',
            'targetForeignKey' => 'timeline_segment_id',
            'joinTable' => 'non_playable_characters_timeline_segments'
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
            ->scalar('name')
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('age')
            ->requirePresence('age', 'create')
            ->notEmpty('age');

        $validator
            ->scalar('appearance')
            ->requirePresence('appearance', 'create')
            ->notEmpty('appearance');

        $validator
            ->scalar('occupation')
            ->maxLength('occupation', 250)
            ->requirePresence('occupation', 'create')
            ->notEmpty('occupation');

        $validator
            ->scalar('personality')
            ->requirePresence('personality', 'create')
            ->notEmpty('personality');

        $validator
            ->scalar('history')
            ->requirePresence('history', 'create')
            ->notEmpty('history');

        $validator
            ->integer('alignment')
            ->requirePresence('alignment', 'create')
            ->notEmpty('alignment');


        return $validator;
    }
}
