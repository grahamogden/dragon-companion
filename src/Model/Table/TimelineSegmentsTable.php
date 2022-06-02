<?php
namespace App\Model\Table;

use App\Model\Entity\TimelineSegment;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Behavior\TreeBehavior;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use App\Model\Behavior\DatabaseStringConverterBehavior;

/**
 * TimelineSegments Model
 *
 * @property CampaignsTable&BelongsTo                 $Campaigns
 * @property TimelineSegmentsTable&BelongsTo          $ParentTimelineSegments
 * @property UsersTable&BelongsTo                     $Users
 * @property TimelineSegmentsTable&HasMany            $ChildTimelineSegments
 // * @property NonPlayableCharactersTable&BelongsToMany $NonPlayableCharacters
 // * @property TagsTable&BelongsToMany                  $Tags
 *
 * @method TimelineSegment get($primaryKey, $options = [])
 * @method TimelineSegment newEntity($data = null, array $options = [])
 * @method TimelineSegment[] newEntities(array $data, array $options = [])
 * @method TimelineSegment|false save(EntityInterface $entity, $options = [])
 * @method TimelineSegment saveOrFail(EntityInterface $entity, $options = [])
 * @method TimelineSegment patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method TimelineSegment[] patchEntities($entities, array $data, array $options = [])
 * @method TimelineSegment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin TimestampBehavior
 * @mixin TreeBehavior
 */
class TimelineSegmentsTable extends Table
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

        $this->setTable('timeline_segments');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('DatabaseStringConverter');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree', [
            'level' => 'level'
        ]);

        $this->belongsTo('Campaigns', [
            'foreignKey' => 'campaign_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ParentTimelineSegments', [
            'className'  => 'TimelineSegments',
            'foreignKey' => 'parent_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'INNER'
        ]);
        $this->hasMany('ChildTimelineSegments', [
            'className'  => 'TimelineSegments',
            'foreignKey' => 'parent_id',
        ]);
        // $this->belongsToMany('NonPlayableCharacters', [
        //     'foreignKey'       => 'timeline_segment_id',
        //     'targetForeignKey' => 'non_playable_character_id',
        //     'joinTable'        => 'non_playable_characters_timeline_segments'
        // ]);
        // $this->belongsToMany('Tags', [
        //     'foreignKey' => 'timeline_segment_id',
        //     'targetForeignKey' => 'tag_id',
        //     'joinTable' => 'tags_timeline_segments',
        // ]);
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
            ->scalar('title')
            ->maxLength('title', 2000)
            ->notEmptyString('title');

        $validator
            ->scalar('body')
            ->requirePresence('body', 'create')
            ->notEmptyString('body');

        return $validator;
    }

    /**
     * Before saving
     *
     * @param Event $event
     * @param type $entity
     * @param type $options
     * @return bool
     */
    public function beforeSave(EventInterface $event, $entity, $options): bool
    {
        // if ($entity->tag_string) {
        //     $entity->tags = $this->_buildTags($entity->tag_string);
        // } else {
        //     $entity->tags = [];
        // }

        // if ($entity->non_playable_character_string) {
        //     $entity->non_playable_characters = $this->_buildNonPlayableCharacters($entity->non_playable_character_string);
        // } else {
        //     $entity->non_playable_characters = [];
        // }

        if ($entity->body) {
            // Ridiculous hack because TinyMCE adds new lines and using the \n
            // to remove it, is not working on its own
            $entity->body = preg_replace('/\n/m', '{--', $entity->body);
            $entity->body = preg_replace('/\s\{\-\-/m', '', $entity->body);
        }

        $sluggedTitle = Text::slug(strtolower($entity->title));
        // trim slug to maximum length defined in schema
        $entity->slug = substr($sluggedTitle, 0, 250);

        return true;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->existsIn(['campaign_id'], 'Campaigns'));
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

        // if (empty($options['tags'])) {
        //     // If there are no tags provided, find timeline segments that have no tags.
        //     $query->leftJoinWith('Tags')
        //         ->where(['Tags.title IS' => null]);
        // } else {
        //     // Find timeline segments that have one or more of the provided tags.
        //     $query->innerJoinWith('Tags')
        //         ->where(['Tags.title IN' => $options['tags']]);
        // }

        return $query->group(['TimelineSegments.id']);
    }

    // /**
    //  * Finds tag records from the list provided and returns them to be added to the User
    //  *
    //  * @param string $tagString
    //  * @return array
    //  */
    // protected function _buildTags(string $tagString): array
    // {
    //     // Trim tags
    //     $newTags = array_map('trim', explode(',', $tagString));
    //     // Remove all empty tags
    //     $newTags = array_filter($newTags);
    //     // Reduce duplicated tags
    //     $newTags = array_unique($newTags);
    //
    //     $out = [];
    //     $query = $this->Tags->find()
    //         ->where(['Tags.title IN' => $newTags]);
    //
    //     // Remove existing tags from the list of new tags.
    //     foreach ($query->extract('title') as $existing) {
    //         $index = array_search($existing, $newTags);
    //         if ($index !== false) {
    //             unset($newTags[$index]);
    //         }
    //     }
    //     // Add existing tags.
    //     foreach ($query as $tag) {
    //         $out[] = $tag;
    //     }
    //
    //     return $out;
    // }

    // /**
    //  * Finds non-playable character records from the list provided and
    //  * returns them to be added to the User
    //  *
    //  * @param string $nonPlayableCharacterString
    //  * @return array
    //  */
    // protected function _buildNonPlayableCharacters(string $nonPlayableCharacterString): array
    // {
    //     // Trim nonPlayableCharacters
    //     $newNonPlayableCharacters = array_map('trim', explode(',', $nonPlayableCharacterString));
    //     // Remove all empty nonPlayableCharacters
    //     $newNonPlayableCharacters = array_filter($newNonPlayableCharacters);
    //     // Reduce duplicated nonPlayableCharacters
    //     $newNonPlayableCharacters = array_unique($newNonPlayableCharacters);
    //
    //     $out = [];
    //     $query = $this->NonPlayableCharacters->find()
    //         ->where(['NonPlayableCharacters.name IN' => $newNonPlayableCharacters]);
    //
    //     // Remove existing nonPlayableCharacters from the list of new nonPlayableCharacters.
    //     foreach ($query->extract('name') as $existing) {
    //         $index = array_search($existing, $newNonPlayableCharacters);
    //         if ($index !== false) {
    //             unset($newNonPlayableCharacters[$index]);
    //         }
    //     }
    //     // Add existing nonPlayableCharacters.
    //     foreach ($query as $nonPlayableCharacter) {
    //         $out[] = $nonPlayableCharacter;
    //     }
    //
    //     return $out;
    // }
}
