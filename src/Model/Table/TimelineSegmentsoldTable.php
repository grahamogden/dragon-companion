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
// the QueryExpressions class
use Cake\Database\Expression\QueryExpression;

class TimelineSegmentsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Tree', [
            'parent' => 'parent_id',
            'left'   => 'previous_id',
            'right'  => 'next_id',
        ]);
        
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags');
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
            $sluggedTitle = Text::slug(strtolower($entity->title));
            // trim slug to maximum length defined in schema
            $entity->slug = substr($sluggedTitle, 0, 250);
        }
    }

    // Add the following method.
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title')
            // ->minLength('title', 10)
            ->maxLength('title', 2000)

            ->notEmpty('body');
            // ->minLength('body', 10);

        return $validator;
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
     * Finds Timeline segments by the provided parent ID
     * 
     * @param Query $query
     * @param array $options
     * 
     * @return Query
     */
    protected function findByParentId(Query $query, array $options): Query
    {
        $returnKey = 'TimelineSegments.id';
        $columns = [
            $returnKey,
            'TimelineSegments.title',
            'TimelineSegments.body',
            'TimelineSegments.created',
            'TimelineSegments.slug',
            'TimelineSegments.parent_id',
            'TimelineSegments.order_number',
        ];

        if ($options['parentId']) {
            $where = [
                'parent_id = ' => $options['parentId']
            ];
        } else {
            $where = [
                'parent_id IS' => null
            ];
        }

        // Find timeline segments that have the provided parent ID
        $query = $query
            ->select($columns)
            ->where($where)
            ->order('previous_id asc');

        return $query->group([$returnKey]);
    }

    /**
     * Finds an timeline segment by its order number
     * @param Query $query 
     * @param array $options 
     * @return type
     */
    protected function findByOrderNumber(Query $query, array $options)
    {
        $columns = [
            'TimelineSegments.id',
            'TimelineSegments.title',
            'TimelineSegments.body',
            'TimelineSegments.created',
            'TimelineSegments.slug',
            'TimelineSegments.parent_id',
            'TimelineSegments.order_number',
        ];

        // Find timeline segments that have the provided parent ID
        $query = $query
            ->select($columns)
            ->where(['order_number = ' => $options['order_number']]);

        return $query->firstOrFail();
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
     * Updates the order for all timeeline segments for the provided parent ID
     * @param int $parentId
     * @param int $orderStartPoint - the number from which to start order everything else from
     * @return type
     */
    public function updateAllOrder(int $parentId, int $orderStartPoint = 0)
    {
        $expression = new QueryExpression('order_number = order_number + 1');
        $this->updateAll([
            $expression
        ], [
            'parent_id'        => $parentId,
            'order_number >'   => $orderStartPoint
        ]);
    }
}