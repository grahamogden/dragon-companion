<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PuzzlesFixture
 *
 */
class PuzzlesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
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
        'title' => [
            'type' => 'string',
            'length' => 250,
            'null' => false,
            'default' => '',
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null,
        ],
        'description' => [
            'type' => 'string',
            'length' => 250,
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null,
        ],
        'slug' => [
            'type' => 'string',
            'length' => 250,
            'null' => false,
            'default' => '',
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null,
        ],
        'created' => [
            'type' => 'datetime',
            'length' => null,
            'null' => false,
            'default' => 'CURRENT_TIMESTAMP',
            'comment' => '',
            'precision' => null,
        ],
        'modified' => [
            'type' => 'datetime',
            'length' => null,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
        ],
        'map' => [
            'type' => 'text',
            'length' => null,
            'null' => false,
            'default' => '',
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null,
        ],
        '_constraints' => [
            'primary' => [
                'type' => 'primary',
                'columns' => [
                    'id',
                ],
                'length' => [],
            ],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci',
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
                'user_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'map' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'slug' => 'Lorem ipsum dolor sit amet',
                'created' => '2018-12-31 17:03:14',
                'modified' => '2018-12-31 17:03:14'
            ],
        ];
        parent::init();
    }
}
