<?php

namespace App\Model\Table;

use App\Model\Entity\Campaign;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Campaigns Model
 *
 * @property CampaignUsersTable&HasMany    $CampaignUsers
 * @property CombatEncountersTable&HasMany $CombatEncounters
 * @property PlayerCharactersTable&HasMany $PlayerCharacters
 * @property TimelineSegmentsTable&HasMany $TimelineSegments
 *
 * @method Campaign get($primaryKey, $options = [])
 * @method Campaign newEntity($data = null, array $options = [])
 * @method Campaign[] newEntities(array $data, array $options = [])
 * @method Campaign|false save(EntityInterface $entity, $options = [])
 * @method Campaign saveOrFail(EntityInterface $entity, $options = [])
 * @method Campaign patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Campaign[] patchEntities($entities, array $data, array $options = [])
 * @method Campaign findOrCreate($search, callable $callback = null, $options = [])
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
    public function initialize(array $config)
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
    public function validationDefault(Validator $validator)
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
}
