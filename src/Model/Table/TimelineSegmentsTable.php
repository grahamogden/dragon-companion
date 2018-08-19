<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
// the Text class
use Cake\Utility\Text;
use App\Model\Behavior\DatabaseStringConverterBehavior;
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

        $this->addBehavior('DatabaseStringConverter');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree', [
            'level' => 'level'
        ]);

        $this->belongsTo('ParentTimelineSegments', [
            'className'  => 'TimelineSegments',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'INNER'
        ]);
        $this->hasMany('ChildTimelineSegments', [
            'className'  => 'TimelineSegments',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey'       => 'timeline_segment_id',
            'targetForeignKey' => 'tag_id',
            'joinTable'        => 'tags_timeline_segments'
        ]);
        $this->belongsToMany('NonPlayableCharacters', [
            'foreignKey'       => 'timeline_segment_id',
            'targetForeignKey' => 'non_playable_character_id',
            'joinTable'        => 'non_playable_characters_timeline_segments'
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

        if ($entity->non_playable_character_string) {
            $entity->non_playable_characters = $this->_buildNonPlayableCharacters($entity->non_playable_character_string);
        }

        $sluggedTitle = Text::slug(strtolower($entity->title));
        // trim slug to maximum length defined in schema
        $entity->slug = substr($sluggedTitle, 0, 250);
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

    // The $query argument is a query builder instance.
    // The $options array will contain the 'tags' option we passed
    // to find('tagged') in our controller action.
    protected function findTagged(Query $query, array $options)
    {
        $columns = [
            'TimelineSegments.id',
            'TimelineSegments.title',
            'TimelineSegments.body',
            'TimelineSegments.created',
            'TimelineSegments.slug',
        ];

        $query = $query
            ->select($columns)
            ->distinct($columns);

        if (empty($options['tags'])) {
            // If there are no tags provided, find timeline segments that have no tags.
            $query->leftJoinWith('Tags')
                ->where(['Tags.title IS' => null]);
        } else {
            // Find timeline segments that have one or more of the provided tags.
            $query->innerJoinWith('Tags')
                ->where(['Tags.title IN' => $options['tags']]);
        }

        return $query->group(['TimelineSegments.id']);
    }
    
    /**
     * Description
     * 
     * @param type $tagString 
     * @return type
     */
    protected function _buildTags($tagString)
    {
        // Trim tags
        $newTags = array_map('trim', explode(',', $tagString));
        // Remove all empty tags
        $newTags = array_filter($newTags);
        // Reduce duplicated tags
        $newTags = array_unique($newTags);

        $out = [];
        $query = $this->Tags->find()
            ->where(['Tags.title IN' => $newTags]);

        // Remove existing tags from the list of new tags.
        foreach ($query->extract('title') as $existing) {
            $index = array_search($existing, $newTags);
            if ($index !== false) {
                unset($newTags[$index]);
            }
        }
        // Add existing tags.
        foreach ($query as $tag) {
            $out[] = $tag;
        }
        // Add new tags.
        foreach ($newTags as $tag) {
            $out[] = $this->Tags->newEntity(['title' => $tag]);
        }

        return $out;
    }
    
    /**
     * Description
     * 
     * @param type $nonPlayableCharacterString 
     * @return type
     */
    protected function _buildNonPlayableCharacters($nonPlayableCharacterString)
    {
        // Trim nonPlayableCharacters
        $newNonPlayableCharacters = array_map('trim', explode(',', $nonPlayableCharacterString));
        // Remove all empty nonPlayableCharacters
        $newNonPlayableCharacters = array_filter($newNonPlayableCharacters);
        // Reduce duplicated nonPlayableCharacters
        $newNonPlayableCharacters = array_unique($newNonPlayableCharacters);

        $out = [];
        $query = $this->NonPlayableCharacters->find()
            ->where(['NonPlayableCharacters.name IN' => $newNonPlayableCharacters]);

        // Remove existing nonPlayableCharacters from the list of new nonPlayableCharacters.
        foreach ($query->extract('name') as $existing) {
            $index = array_search($existing, $newNonPlayableCharacters);
            if ($index !== false) {
                unset($newNonPlayableCharacters[$index]);
            }
        }
        // Add existing nonPlayableCharacters.
        foreach ($query as $nonPlayableCharacter) {
            $out[] = $nonPlayableCharacter;
        }
        // TODO: Return some kind of response that the user cannot create a character here
        // Add new nonPlayableCharacters.
        // foreach ($newNonPlayableCharacters as $nonPlayableCharacter) {
        //     $out[] = $this->NonPlayableCharacters->newEntity(['name' => $nonPlayableCharacter]);
        // }

        return $out;
    }
}
