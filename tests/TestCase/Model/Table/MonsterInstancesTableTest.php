<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MonsterInstancesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MonsterInstancesTable Test Case
 */
class MonsterInstancesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MonsterInstancesTable
     */
    public $MonsterInstances;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.monster_instances',
        'app.monsters',
        'app.participants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MonsterInstances') ? [] : ['className' => MonsterInstancesTable::class];
        $this->MonsterInstances = TableRegistry::getTableLocator()->get('MonsterInstances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MonsterInstances);

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
