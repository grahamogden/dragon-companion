<?php
namespace App\Model\Table;

// the Table class
use Cake\ORM\Table;
// the Text class
use Cake\Utility\Text;
// the Validator class
use Cake\Validation\Validator;
// the Query class
use Cake\ORM\Query;

class TimelineSegmentsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags');
    }

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

    // Add the following method.
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title')
            ->minLength('title', 10)
            ->maxLength('title', 2000)

            ->notEmpty('body')
            ->minLength('body', 10);

        return $validator;
    }

    // The $query argument is a query builder instance.
    // The $options array will contain the 'tags' option we passed
    // to find('tagged') in our controller action.
    public function findTagged(Query $query, array $options)
    {
        $columns = [
            'TimelineSegments.id', 'TimelineSegments.title',
            'TimelineSegments.body', 'TimelineSegments.created',
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
     * Finds Timeline segments by the provided parent ID
     * 
     * @param Query $query
     * @param array $options
     * 
     * @return Query
     */
    public function findByParentId(Query $query, array $options): Query
    {
        $returnKey = 'TimelineSegments.id';
        $columns = [
            $returnKey,
            'TimelineSegments.title',
            'TimelineSegments.body',
            'TimelineSegments.created',
            'TimelineSegments.slug',
            'TimelineSegments.parent_id',
        ];

        // Find timeline segments that have the provided parent ID
        $query = $query
            ->select($columns)
            ->distinct($columns)
            ->where(['parent_id = ' => $options['parentId']]);

        return $query->group([$returnKey]);
    }

    /**
     * Finds all of the ancestors based on the current item's ID
     * 
     * @param Query $query 
     * @param array $options
     * 
     * @return TimelineSegment
     */
    public function findAncestorByParentId(Query $query, array $options)//: TimelineSegment
    {
        $returnKey = 'TimelineSegments.id';
        $columns = [
            $returnKey,
            'TimelineSegments.title',
            'TimelineSegments.parent_id',
        ];

        $query = $query
            ->select($columns)
            ->distinct($columns)
            ->where(['id' => $options['parentId']]);

        return $query->firstOrFail([$returnKey]);
    }
    
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
}