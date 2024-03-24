<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CampaignUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CampaignUsersTable Test Case
 */
class CampaignUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CampaignUsersTable
     */
    public $CampaignUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'app.CampaignUsers',
        'app.Campaigns',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CampaignUsers') ? [] : ['className' => CampaignUsersTable::class];
        $this->CampaignUsers = TableRegistry::getTableLocator()->get('CampaignUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CampaignUsers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
