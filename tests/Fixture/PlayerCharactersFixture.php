<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlayerCharactersFixture
 *
 */
class PlayerCharactersFixture extends TestFixture
{
    /** @var array $fields */
    public $fields = [
        'id' => [
            'type' => 'integer',
            'length' => 11,
            'unsigned' => true,
            'null' => false,
            'default' => null,
            'comment' => '',
            'autoIncrement' => true,
            'precision' => null,
        ],
        'user_id' => [
            'type' => 'integer',
            'length' => 11,
            'unsigned' => true,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null,
        ],
        'first_name' => [
            'type' => 'string',
            'length' => 250,
            'null' => false,
            'default' => '',
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null,
        ],
        'last_name' => [
            'type' => 'string',
            'length' => 250,
            'null' => false,
            'default' => '',
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null,
        ],
        'age' => [
            'type' => 'integer',
            'length' => 7,
            'unsigned' => false,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null,
        ],
        'max_hp' => [
            'type' => 'integer',
            'length' => 6,
            'unsigned' => false,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null,
        ],
        'current_hp' => [
            'type' => 'integer',
            'length' => 6,
            'unsigned' => false,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null,
        ],
        'armour_class' => [
            'type' => 'integer',
            'length' => 3,
            'unsigned' => false,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null,
        ],
        '_constraints' => [

            'primary' => [
                'type' => 'primary',
                'columns' => ['id',
            ],
                'length' => [],
            ],
        ],
        '_options' => [
            'engine'    => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];

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
                'user_id' => 1,
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'age' => 1,
                'max_hp' => 1,
                'current_hp' => 1,
                'armour_class' => 1
            ],
        ];
        parent::init();
    }
}
