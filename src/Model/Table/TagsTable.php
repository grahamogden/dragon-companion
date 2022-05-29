<?php
namespace App\Model\Table;

use \App\Model\Entity\Tag;
use \App\Model\Table\UsersTable;
use \App\Model\Table\TimelineSegmentsTable;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;

/**
 * Tags Model
 *
 * @property UsersTable&BelongsTo $Users
 * @property TimelineSegmentsTable&BelongsToMany $TimelineSegments
 *
 * @method Tag get($primaryKey, $options = [])
 * @method Tag newEntity($data = null, array $options = [])
 * @method Tag[] newEntities(array $data, array $options = [])
 * @method Tag|false save(EntityInterface $entity, $options = [])
 * @method Tag saveOrFail(EntityInterface $entity, $options = [])
 * @method Tag patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Tag[] patchEntities($entities, array $data, array $options = [])
 * @method Tag findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TagsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tags');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'INNER',
        ]);

        $this->belongsToMany('TimelineSegments', [
            'foreignKey'       => 'tag_id',
            'targetForeignKey' => 'timeline_segment_id',
            'joinTable'        => 'tags_timeline_segments',
        ]);
    }

    /**
     * Before saving
     * 
     * @param type $event 
     * @param type $entity 
     * @param type $options 
     * @return type
     */
    public function beforeSave(\Cake\Event\EventInterface $event, $entity, $options)
    {
        $sluggedTitle = Text::slug(strtolower($entity->title));
        // trim slug to maximum length defined in schema
        $entity->slug = substr($sluggedTitle, 0, 250);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->minLength('title', 3)
            ->maxLength('title', 255)
            ->notEmptyString('title')
            ->notEmpty('title')
            ->add('title', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 250)
            ->notEmptyString('slug');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->isUnique(['title']));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
