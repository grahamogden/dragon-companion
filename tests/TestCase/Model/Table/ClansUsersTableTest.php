<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClansUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClansUsersTable Test Case
 */
class ClansUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ClansUsersTable
     */
    public $ClansUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'app.ClansUsers',
        'app.Clans',
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
        $config = TableRegistry::getTableLocator()->exists('ClansUsers') ? [] : ['className' => ClansUsersTable::class];
        $this->ClansUsers = TableRegistry::getTableLocator()->get('ClansUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClansUsers);

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
