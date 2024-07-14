<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Error\Api\UnauthorizedError;
use App\Model\Entity\Role;
use App\Model\Entity\Timeline;
use App\Model\Entity\TimelinePermission;
use App\Model\Entity\User;
use App\Model\Enum\RolePermission;
use App\Services\TablePermissionsHelper\TablePermissionsHelper;
use ArrayObject;
use Authorization\Identity;
use Cake\Datasource\QueryInterface;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Timelines Model
 *
 * @property CampaignsTable&BelongsTo $Campaigns
 * @property UsersTable&BelongsTo $Users
 * @property TimelinesTable&BelongsTo $ParentTimelines
 * @property TimelinesTable&HasMany $ChildTimelines
 * @property RolesTable&BelongsToMany $Roles
 *
 * @method \App\Model\Entity\Timeline newEmptyEntity()
 * @method \App\Model\Entity\Timeline newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Timeline> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Timeline get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Timeline findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Timeline patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Timeline> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Timeline|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Timeline saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Timeline>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Timeline>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Timeline>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Timeline> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Timeline>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Timeline>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Timeline>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Timeline> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class TimelinesTable extends Table
{
    public const TABLE_NAME = 'timelines';

    private readonly TablePermissionsHelper $tablePermissionsHelper;

    public function __construct(array $config)
    {
        parent::__construct(config: $config);
        $this->tablePermissionsHelper = new TablePermissionsHelper();
    }

    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable(self::TABLE_NAME);
        $this->setDisplayField(Timeline::FIELD_TITLE);
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree', [
            'level' => 'level',
            'cascadeCallbacks' => true,
        ]);

        $this->belongsTo('Campaigns', [
            'foreignKey' => Timeline::FIELD_CAMPAIGN_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => Timeline::FIELD_USER_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ParentTimelines', [
            'className' => 'Timelines',
            'foreignKey' => Timeline::FIELD_PARENT_ID,
        ]);
        $this->hasMany('ChildTimelines', [
            'className' => 'Timelines',
            'foreignKey' => Timeline::FIELD_PARENT_ID,
        ]);
        $this->hasMany('TimelinePermissions', [
            'foreignKey' => 'timeline_id',
        ]);
        // $this->belongsToMany('Roles', [
        //     'foreignKey' => 'timeline_id',
        //     'targetForeignKey' => 'role_id',
        //     'joinTable' => 'roles_timelines',
        // ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger(Timeline::FIELD_CAMPAIGN_ID)
            ->notEmptyString(Timeline::FIELD_CAMPAIGN_ID);

        $validator
            ->scalar(Timeline::FIELD_TITLE)
            ->minLength(Timeline::FIELD_TITLE, 3)
            ->maxLength(Timeline::FIELD_TITLE, 2000)
            ->notEmptyString(Timeline::FIELD_TITLE);

        $validator
            ->scalar(Timeline::FIELD_BODY)
            ->requirePresence(Timeline::FIELD_BODY)
            ->notEmptyString(Timeline::FIELD_BODY);

        $validator
            ->nonNegativeInteger(Timeline::FIELD_USER_ID)
            ->requirePresence(Timeline::FIELD_USER_ID, 'create')
            ->notEmptyString(Timeline::FIELD_USER_ID);

        $validator
            ->integer(Timeline::FIELD_PARENT_ID)
            ->allowEmptyString(Timeline::FIELD_PARENT_ID);

        // $validator
        //     ->integer(Timeline::FIELD_LEVEL)
        //     ->requirePresence(Timeline::FIELD_LEVEL, 'create')
        //     ->notEmptyString(Timeline::FIELD_LEVEL);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn([Timeline::FIELD_CAMPAIGN_ID], 'Campaigns'), ['errorField' => Timeline::FIELD_CAMPAIGN_ID]);
        $rules->add($rules->existsIn([Timeline::FIELD_USER_ID], 'Users'), ['errorField' => Timeline::FIELD_USER_ID]);
        $rules->add($rules->existsIn([Timeline::FIELD_PARENT_ID], 'ParentTimelines'), ['errorField' => Timeline::FIELD_PARENT_ID]);

        return $rules;
    }

    public function findOneByIdAndCampaignId(int $id, int $campaignId, bool $includeChildren = false): ?Timeline
    {
        $contains = [TimelinePermission::ENTITY_NAME];

        if ($includeChildren) {
            $contains[] = Timeline::ASSOC_CHILD_TIMELINES;
        }

        $query = $this->find()
            ->where([
                Timeline::FIELD_ID => $id,
                Timeline::FIELD_CAMPAIGN_ID => $campaignId,
            ])
            ->contain($contains);

        return $query->first();

        // $entity = $this->get($id);
        // dd($entity);
        // if ($entity->campaign_id === $campaignId) {
        //     return $entity;
        // }

        // return null;
    }

    /**
     * @return Timeline
     */
    public function findByCampaignId(int $campaignId): ?array
    {
        try {
            $query = $this->find()
                ->where([Timeline::FIELD_CAMPAIGN_ID => $campaignId])
                ->contain([TimelinePermission::ENTITY_NAME]);

            return $query->first();
        } catch (RecordNotFoundException $exception) {
            return null;
        }
    }

    public function findByCampaignIdForLevelWithPermissionsCheck(int $campaignId, Identity $identity, int $level = 0, bool $includeChildren = false): ?QueryInterface
    {
        $role = $this->tablePermissionsHelper->getUserRoleForCampaignOrThrowUnauthorizedError(
            identity: $identity,
            campaignId: $campaignId
        );

        $contains = [TimelinePermission::ENTITY_NAME];

        if ($includeChildren) {
            $contains[] = Timeline::ASSOC_CHILD_TIMELINES;
        }

        try {
            $query = $this->tablePermissionsHelper->addReadPermissionsChecksToQuery(
                query: $this->find()
                    ->where([
                        Timeline::ENTITY_NAME . '.' . Timeline::FIELD_CAMPAIGN_ID => $campaignId,
                        Timeline::ENTITY_NAME . '.' . Timeline::FIELD_LEVEL => $level,
                    ])
                    ->contain($contains),
                permissionEntityName: TimelinePermission::ENTITY_NAME,
                role: $role
            );

            return $query;
        } catch (RecordNotFoundException $exception) {
            return null;
        }
    }

    public function findByCampaignIdWithPermissionsCheck(int $campaignId, Identity $identity, bool $includeChildren = false): ?QueryInterface
    {
        $role = $this->tablePermissionsHelper->getUserRoleForCampaignOrThrowUnauthorizedError(
            identity: $identity,
            campaignId: $campaignId
        );

        $contains = [TimelinePermission::ENTITY_NAME];

        if ($includeChildren) {
            $contains[] = Timeline::ASSOC_CHILD_TIMELINES;
        }

        try {
            $query = $this->tablePermissionsHelper->addReadPermissionsChecksToQuery(
                query: $this->find()
                    ->where([
                        Timeline::ENTITY_NAME . '.' . Timeline::FIELD_CAMPAIGN_ID => $campaignId,
                    ])
                    ->contain($contains),
                permissionEntityName: TimelinePermission::ENTITY_NAME,
                role: $role
            );

            return $query;
        } catch (RecordNotFoundException $exception) {
            return null;
        }
    }

    // public function beforeSave(EventInterface $event, EntityInterface & Timeline $entity, ArrayObject $options): void
    // {
    //     // $config = $this->getConfig();
    //     // $value = $entity->get($config['field']);
    //     // $entity->set($config['slug'], Text::slug($value, $config['replacement']));
    //     if (!$entity->level) {
    //         $entity->level = ($entity->getParentTimeline()?->level ?? 0) + 1;
    //     }
    // }

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
