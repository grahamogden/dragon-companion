<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CombatTurnsFixture
 */
class CombatTurnsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'combat_encounter_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'round_number' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => 'The current round number that this turn is in', 'precision' => null, 'autoIncrement' => null],
        'turn_order' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => 'The incrementing number that represents when this precise turn occurred in combat', 'precision' => null, 'autoIncrement' => null],
        'source_participant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => 'The participant that initiates the action. This can be null as damage may be taken due to environmental conditions but the environment is not a participant.', 'precision' => null, 'autoIncrement' => null],
        'target_participant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => 'The participant that receives the action (be that damage or healing), which can never be null as something will always happen to someone.', 'precision' => null, 'autoIncrement' => null],
        'combat_action_id' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => 'Foreign key to the combat_actions table and represents what action the user took for their turn - attack, heal, disengage, pass their turn, etc.', 'precision' => null, 'autoIncrement' => null],
        'roll_total' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'The total roll of the user\'s dice to initiate the action. For example, the total of rolling 4d10 + 5 = 29', 'precision' => null, 'autoIncrement' => null],
        'net_action_total' => ['type' => 'float', 'length' => 9, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'The total amount of damage/healing/etc that the target received. Could be null as the target may not take any damage or healing during their turn (potentially could be 0)'],
        'movement' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => 'The distance that the source participant moved during their turn.', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'combat_encounter_id' => ['type' => 'index', 'columns' => ['combat_encounter_id'], 'length' => []],
            'source_participant_id' => ['type' => 'index', 'columns' => ['source_participant_id'], 'length' => []],
            'target_participant_id' => ['type' => 'index', 'columns' => ['target_participant_id'], 'length' => []],
            'combat_action_id' => ['type' => 'index', 'columns' => ['combat_action_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'combat_turns_ibfk_1' => ['type' => 'foreign', 'columns' => ['combat_encounter_id'], 'references' => ['combat_encounters', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'combat_turns_ibfk_2' => ['type' => 'foreign', 'columns' => ['source_participant_id'], 'references' => ['participants', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'combat_turns_ibfk_3' => ['type' => 'foreign', 'columns' => ['target_participant_id'], 'references' => ['participants', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'combat_turns_ibfk_4' => ['type' => 'foreign', 'columns' => ['combat_action_id'], 'references' => ['combat_actions', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];

    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'combat_encounter_id' => 1,
                'round_number' => 1,
                'turn_order' => 1,
                'source_participant_id' => 1,
                'target_participant_id' => 1,
                'combat_action_id' => 1,
                'roll_total' => 1,
                'net_action_total' => 1,
                'movement' => 1,
            ],
        ];
        parent::init();
    }
}
