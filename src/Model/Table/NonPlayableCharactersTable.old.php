<?php

// namespace App\Model\Table;

// use App\Model\Entity\NonPlayableCharacter;
// use Cake\Datasource\EntityInterface;
// use Cake\ORM\Association\BelongsTo;
// use Cake\ORM\Association\BelongsToMany;
// use Cake\ORM\RulesChecker;
// use Cake\ORM\Table;
// use Cake\Validation\Validator;

// /**
//  * NonPlayableCharacters Model
//  *
//  * @property AlignmentsTable&BelongsTo           $Alignments
//  * @property UsersTable&BelongsTo                $Users
//  * @property TimelineSegmentsTable&BelongsToMany $TimelineSegments
//  *
//  * @method NonPlayableCharacter get($primaryKey, $options = [])
//  * @method NonPlayableCharacter newEntity($data = null, array $options = [])
//  * @method NonPlayableCharacter[] newEntities(array $data, array $options = [])
//  * @method NonPlayableCharacter|false save(EntityInterface $entity, $options = [])
//  * @method NonPlayableCharacter saveOrFail(EntityInterface $entity, $options = [])
//  * @method NonPlayableCharacter patchEntity(EntityInterface $entity, array $data, array $options = [])
//  * @method NonPlayableCharacter[] patchEntities($entities, array $data, array $options = [])
//  * @method NonPlayableCharacter findOrCreate($search, callable $callback = null, $options = [])
//  */
// class NonPlayableCharactersTable extends Table
// {
//     /**
//      * Initialize method
//      *
//      * @param array $config The configuration for the Table.
//      *
//      * @return void
//      */
//     public function initialize(array $config): void
//     {
//         parent::initialize($config);

//         $this->setTable('non_playable_characters');
//         $this->setDisplayField('name');
//         $this->setPrimaryKey('id');

//         $this->belongsTo(
//             'Alignments',
//             [
//                 'foreignKey' => 'alignment_id',
//                 'joinType'   => 'INNER',
//             ]
//         );
//         $this->belongsTo(
//             'Users',
//             [
//                 'foreignKey' => 'user_id',
//                 'joinType'   => 'INNER',
//             ]
//         );
//         $this->belongsToMany(
//             'TimelineSegments',
//             [
//                 'foreignKey'       => 'non_playable_character_id',
//                 'targetForeignKey' => 'timeline_segment_id',
//                 'joinTable'        => 'non_playable_characters_timeline_segments',
//             ]
//         );
//     }

//     /**
//      * Default validation rules.
//      *
//      * @param Validator $validator Validator instance.
//      *
//      * @return Validator
//      */
//     public function validationDefault(Validator $validator): \Cake\Validation\Validator
//     {
//         $validator
//             ->nonNegativeInteger('id')
//             ->allowEmptyString('id', null, 'create');

//         $validator
//             ->scalar('name')
//             ->maxLength('name', 250)
//             ->requirePresence('name', 'create')
//             ->notEmptyString('name');

//         $validator
//             ->integer('age')
//             ->notEmptyString('age');

//         $validator
//             ->scalar('appearance')
//             ->allowEmptyString('appearance');

//         $validator
//             ->scalar('occupation')
//             ->maxLength('occupation', 250)
//             ->allowEmptyString('occupation');

//         $validator
//             ->scalar('personality')
//             ->allowEmptyString('personality');

//         $validator
//             ->scalar('history')
//             ->allowEmptyString('history');

//         $validator
//             ->scalar('notes')
//             ->allowEmptyString('notes');

//         return $validator;
//     }

//     /**
//      * Returns a rules checker object that will be used for validating
//      * application integrity.
//      *
//      * @param RulesChecker $rules The rules object to be modified.
//      *
//      * @return RulesChecker
//      */
//     public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
//     {
//         $rules->add($rules->existsIn(['alignment_id'], 'Alignments'));
//         $rules->add($rules->existsIn(['user_id'], 'Users'));

//         return $rules;
//     }
// }
