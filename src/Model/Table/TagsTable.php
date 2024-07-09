<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Tag;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tags Model
 *
 * @property CampaignsTable&BelongsTo $Campaigns
 * @property UsersTable&BelongsTo $Users
 * @property RolesTable&BelongsToMany $Roles
 *
 * @method \App\Model\Entity\Tag newEmptyEntity()
 * @method \App\Model\Entity\Tag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Tag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Tag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Tag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Tag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Tag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Tag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tag> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TagsTable extends Table
{
    public const TABLE_NAME = 'tags';



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
        $this->setDisplayField(Tag::FIELD_TAG_NAME);
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Campaigns', [
            'foreignKey' => Tag::FIELD_CAMPAIGN_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => Tag::FIELD_USER_ID,
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Roles', [
            'foreignKey' => 'tag_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'roles_tags',
        ]);
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
            ->nonNegativeInteger(Tag::FIELD_CAMPAIGN_ID)
            ->notEmptyString(Tag::FIELD_CAMPAIGN_ID);

        $validator
            ->scalar(Tag::FIELD_TAG_NAME)
            ->minLength(Tag::FIELD_TAG_NAME, 3)
            ->maxLength(Tag::FIELD_TAG_NAME, 255)
            ->notEmptyString(Tag::FIELD_TAG_NAME);

        $validator
            ->scalar(Tag::FIELD_DESCRIPTION)
            ->requirePresence(Tag::FIELD_DESCRIPTION, 'create')
            ->notEmptyString(Tag::FIELD_DESCRIPTION);

        $validator
            ->nonNegativeInteger(Tag::FIELD_USER_ID)
            ->notEmptyString(Tag::FIELD_USER_ID);

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
        $rules->add($rules->existsIn([Tag::FIELD_CAMPAIGN_ID], 'Campaigns'), ['errorField' => Tag::FIELD_CAMPAIGN_ID]);
        $rules->add($rules->existsIn([Tag::FIELD_USER_ID], 'Users'), ['errorField' => Tag::FIELD_USER_ID]);

        return $rules;
    }
}
