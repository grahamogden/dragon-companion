<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CharacterRacesPlayerCharactersFixture
 */
class CharacterRacesPlayerCharactersFixture extends TestFixture
{
    
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'character_race_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'player_character_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'player_character_id' => ['type' => 'index', 'columns' => ['player_character_id'], 'length' => []],
            'character_race_id' => ['type' => 'index', 'columns' => ['character_race_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'character_races_player_characters_ibfk_2' => ['type' => 'foreign', 'columns' => ['player_character_id'], 'references' => ['player_characters', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'character_races_player_characters_ibfk_3' => ['type' => 'foreign', 'columns' => ['character_race_id'], 'references' => ['character_races', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'character_race_id' => 1,
                'player_character_id' => 1,
            ],
        ];
        parent::init();
    }
}
