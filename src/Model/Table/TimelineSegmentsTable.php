<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
// the Text class
use Cake\Utility\Text;
// the QueryExpressions class
// use Cake\Database\Expression\QueryExpression;

/**
 * TimelineSegments Model
 *
 * @property \App\Model\Table\TimelineSegmentsTable|\Cake\ORM\Association\BelongsTo $ParentTimelineSegments
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\TimelineSegmentsTable|\Cake\ORM\Association\HasMany $ChildTimelineSegments
 * @property \App\Model\Table\TagsTable|\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\TimelineSegment get($primaryKey, $options = [])
 * @method \App\Model\Entity\TimelineSegment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TimelineSegment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TimelineSegment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TimelineSegment|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TimelineSegment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TimelineSegment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TimelineSegment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class TimelineSegmentsTable extends Table
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

        $this->setTable('timeline_segments');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree', [
            'level' => 'level'
        ]);

        $this->belongsTo('ParentTimelineSegments', [
            'className' => 'TimelineSegments',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ChildTimelineSegments', [
            'className' => 'TimelineSegments',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'timeline_segment_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'tags_timeline_segments'
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
            ->scalar('title')
            ->maxLength('title', 2000)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('body')
            ->requirePresence('body', 'create')
            ->notEmpty('body');

        // $validator
        //     ->scalar('slug')
        //     ->maxLength('slug', 250)
        //     ->requirePresence('slug', 'create')
        //     ->notEmpty('slug');

        return $validator;
    }

    /**
     * Before saving
     * 
     * @param type $event 
     * @param type $entity 
     * @param type $options 
     * @return type
     */
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->tag_string) {
            $entity->tags = $this->_buildTags($entity->tag_string);
        }

        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            // trim slug to maximum length defined in schema
            $entity->slug = substr($sluggedTitle, 0, 250);
        }
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
        $rules->add($rules->existsIn(['parent_id'], 'ParentTimelineSegments'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
