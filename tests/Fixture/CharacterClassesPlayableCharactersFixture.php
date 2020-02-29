<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CharacterClassesPlayableCharactersFixture
 *
 */
class CharacterClassesPlayableCharactersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'character_class_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'player_character_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'character_class_id' => ['type' => 'index', 'columns' => ['character_class_id'], 'length' => []],
            'player_character_id' => ['type' => 'index', 'columns' => ['player_character_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'character_classes_playable_characters_ibfk_1' => ['type' => 'foreign', 'columns' => ['character_class_id'], 'references' => ['character_classes', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'character_classes_playable_characters_ibfk_2' => ['type' => 'foreign', 'columns' => ['player_character_id'], 'references' => ['playable_characters', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'character_class_id' => 1,
                'player_character_id' => 1
            ],
        ];
        parent::init();
    }
}
