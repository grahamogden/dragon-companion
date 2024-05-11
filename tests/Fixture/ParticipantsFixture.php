<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ParticipantsFixture
 */
class ParticipantsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'initiative' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'combat_encounter_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'monster_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'player_character_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'starting_hit_points' => ['type' => 'float', 'length' => 9, 'precision' => 3, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => ''],
        'current_hit_points' => ['type' => 'float', 'length' => 9, 'precision' => 3, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => ''],
        'armour_class' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'temporary_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'combat_encounter_id' => ['type' => 'index', 'columns' => ['combat_encounter_id'], 'length' => []],
            'monster_id' => ['type' => 'index', 'columns' => ['monster_id'], 'length' => []],
            'player_character_id' => ['type' => 'index', 'columns' => ['player_character_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'participants_ibfk_1' => ['type' => 'foreign', 'columns' => ['combat_encounter_id'], 'references' => ['combat_encounters', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'participants_ibfk_2' => ['type' => 'foreign', 'columns' => ['monster_id'], 'references' => ['monsters', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'participants_ibfk_3' => ['type' => 'foreign', 'columns' => ['player_character_id'], 'references' => ['player_characters', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'initiative' => 1,
                'combat_encounter_id' => 1,
                'monster_id' => 1,
                'player_character_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'starting_hit_points' => 1,
                'current_hit_points' => 1,
                'armour_class' => 1,
                'temporary_id' => 1,
            ],
        ];
        parent::init();
    }
}
