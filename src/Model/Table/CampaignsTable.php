<?php

namespace App\Model\Table;

use App\Model\Entity\Campaign;
use App\Model\Entity\User;
use Cake\Database\Query;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\ORM\Query\SelectQuery;
use Cake\Validation\Validator;

/**
 * Campaigns Model
 *
 * @property CampaignUsersTable&HasMany    $CampaignUsers
 * @property CombatEncountersTable&HasMany $CombatEncounters
 * @property PlayerCharactersTable&HasMany $PlayerCharacters
 * @property TimelineSegmentsTable&HasMany $TimelineSegments
 */
class CampaignsTable extends Table
{
    public const TABLE_NAME = 'campaigns';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable(self::TABLE_NAME);
        $this->setDisplayField(Campaign::FIELD_NAME);
        $this->setPrimaryKey(Campaign::FIELD_ID);

        $this->hasMany(
            'CampaignUsers',
            [
                'foreignKey' => 'campaign_id',
            ]
        );
        $this->hasMany(
            'CombatEncounters',
            [
                'foreignKey' => 'campaign_id',
            ]
        );
        $this->hasMany(
            'PlayerCharacters',
            [
                'foreignKey' => 'campaign_id',
            ]
        );
        $this->hasMany(
            'TimelineSegments',
            [
                'foreignKey' => 'campaign_id',
            ]
        );
        $this->belongsToMany('Users', [
            'foreignKey' => 'campaign_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'campaign_users',
        ]);
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
            ->nonNegativeInteger(Campaign::FIELD_ID)
            ->allowEmptyString(Campaign::FIELD_ID, null, 'create');

        $validator
            ->scalar(Campaign::FIELD_NAME)
            ->maxLength(Campaign::FIELD_NAME, 250)
            ->requirePresence(Campaign::FIELD_NAME)
            ->notEmptyString(Campaign::FIELD_NAME);

        $validator
            ->scalar(Campaign::FIELD_SYNOPSIS)
            ->maxLength(Campaign::FIELD_SYNOPSIS, 1000)
            ->allowEmptyString(Campaign::FIELD_SYNOPSIS);

        return $validator;
    }

    public function findByIdWithUsers(int $id): Campaign
    {
        /** @var Campaign $entity */
        $entity = $this->get($id, contain: User::ENTITY_NAME);

        return $entity;
    }

    public function findAllByUserId($userId): SelectQuery
    {
        return $this->find()->matching(
            User::ENTITY_NAME,
            function (Query $q) use ($userId) {
                return $q->where([User::ENTITY_NAME . '.' . User::FIELD_ID => $userId]);
            }
        );
    }
}
