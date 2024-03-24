<?php

namespace App\Model\Table;

use App\Model\Entity\Campaign;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\ORM\Query;
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

        $this->setTable('campaigns');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->notEmptyString('name');

        $validator
            ->scalar('synopsis')
            ->maxLength('synopsis', 1000)
            ->allowEmptyString('synopsis');

        return $validator;
    }

    public function findByIdWithUsers(int $id): Campaign
    {
        return $this->get($id, contain: 'Users');
    }

    public function findAllByUserId($userId): Query
    {
        return $this->find()->matching(
            'Users',
            function (Query $q) use ($userId) {
                return $q->where(['Users.id =' => $userId]);
            }
        );
    }
}
