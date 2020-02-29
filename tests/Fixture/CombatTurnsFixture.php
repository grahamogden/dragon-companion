<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CombatTurnsFixture
 *
 */
class CombatTurnsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'combat_enounter_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'round_number' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'source_participant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'target_participant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'action_result' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'condition_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'combat_enounter_id' => ['type' => 'index', 'columns' => ['combat_enounter_id'], 'length' => []],
            'source_participant_id' => ['type' => 'index', 'columns' => ['source_participant_id'], 'length' => []],
            'target_participant_id' => ['type' => 'index', 'columns' => ['target_participant_id'], 'length' => []],
            'condition_id' => ['type' => 'index', 'columns' => ['condition_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'combat_turns_ibfk_1' => ['type' => 'foreign', 'columns' => ['combat_enounter_id'], 'references' => ['combat_encounters', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'combat_turns_ibfk_2' => ['type' => 'foreign', 'columns' => ['source_participant_id'], 'references' => ['participants', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'combat_turns_ibfk_3' => ['type' => 'foreign', 'columns' => ['target_participant_id'], 'references' => ['participants', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'combat_turns_ibfk_4' => ['type' => 'foreign', 'columns' => ['condition_id'], 'references' => ['conditions', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'combat_enounter_id' => 1,
                'round_number' => 1,
                'source_participant_id' => 1,
                'target_participant_id' => 1,
                'action_result' => 1,
                'condition_id' => 1
            ],
        ];
        parent::init();
    }
}
