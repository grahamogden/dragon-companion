<?php
namespace App\Model\Table;

use App\Model\Entity\CombatEncounter;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CombatEncounters Model
 *
 * @property UsersTable&BelongsTo      $Users
 * @property CampaignsTable&BelongsTo  $Campaigns
 * @property ParticipantsTable&HasMany $Participants
 *
 * @method CombatEncounter get($primaryKey, $options = [])
 * @method CombatEncounter newEntity($data = null, array $options = [])
 * @method CombatEncounter[] newEntities(array $data, array $options = [])
 * @method CombatEncounter|false save(EntityInterface $entity, $options = [])
 * @method CombatEncounter saveOrFail(EntityInterface $entity, $options = [])
 * @method CombatEncounter patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CombatEncounter[] patchEntities($entities, array $data, array $options = [])
 * @method CombatEncounter findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin TimestampBehavior
 */
class CombatEncountersTable extends Table
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

        $this->setTable('combat_encounters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo(
            'Users',
            [
                'foreignKey' => 'user_id',
                'joinType'   => 'INNER',
            ]
        );
        $this->belongsTo(
            'Campaigns',
            [
                'foreignKey' => 'campaign_id',
                'joinType'   => 'INNER',
            ]
        );
        $this->hasMany(
            'Participants',
            [
                'foreignKey' => 'combat_encounter_id',
            ]
        );
        $this->hasMany(
            'CombatTurns',
            [
                'foreignKey' => 'combat_encounter_id',
            ]
        );
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
            ->allowEmptyString('name');

        $validator
            ->nonNegativeInteger('campaign_id')
            ->requirePresence('campaign_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     *
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['campaign_id'], 'Campaigns'));

        return $rules;
    }
}
