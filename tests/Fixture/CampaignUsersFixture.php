<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CampaignUsersFixture
 */
class CampaignUsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id'            => [
            'type'          => 'integer',
            'length'        => 11,
            'unsigned'      => true,
            'null'          => false,
            'default'       => null,
            'comment'       => '',
            'autoIncrement' => true,
            'precision'     => null,
        ],
        'campaign_id'   => [
            'type'          => 'integer',
            'length'        => 11,
            'unsigned'      => true,
            'null'          => false,
            'default'       => null,
            'comment'       => '',
            'precision'     => null,
            'autoIncrement' => null,
        ],
        'user_id'       => [
            'type'          => 'integer',
            'length'        => 11,
            'unsigned'      => true,
            'null'          => false,
            'default'       => null,
            'comment'       => '',
            'precision'     => null,
            'autoIncrement' => null,
        ],
        'member_status' => ['type'          => 'integer',
                            'length'        => 2,
                            'unsigned'      => false,
                            'null'          => false,
                            'default'       => '0',
                            'comment'       => '',
                            'precision'     => null,
                            'autoIncrement' => null,
        ],
        'account_level' => ['type'          => 'integer',
                            'length'        => 2,
                            'unsigned'      => false,
                            'null'          => false,
                            'default'       => '0',
                            'comment'       => '',
                            'precision'     => null,
                            'autoIncrement' => null,
        ],
        '_indexes'      => [
            'user_id'     => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'campaign_id' => ['type' => 'index', 'columns' => ['campaign_id'], 'length' => []],
        ],
        '_constraints'  => [
            'primary'                => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'campaigns_users_ibfk_1' => ['type'       => 'foreign',
                                         'columns'    => ['user_id'],
                                         'references' => ['users', 'id'],
                                         'update'     => 'cascade',
                                         'delete'     => 'cascade',
                                         'length'     => [],
            ],
            'campaigns_users_ibfk_2' => ['type'       => 'foreign',
                                         'columns'    => ['campaign_id'],
                                         'references' => ['campaigns', 'id'],
                                         'update'     => 'cascade',
                                         'delete'     => 'cascade',
                                         'length'     => [],
            ],
        ],
        '_options'      => [
            'engine'    => 'InnoDB',
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
                'id'            => 1,
                'campaign_id'   => 1,
                'user_id'       => 1,
                'member_status' => 1,
                'account_level' => 1,
            ],
        ];
        parent::init();
    }
}
