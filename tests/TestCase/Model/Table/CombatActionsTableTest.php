<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CombatActionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CombatActionsTable Test Case
 */
class CombatActionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CombatActionsTable
     */
    public $CombatActions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CombatActions',
        'app.CombatTurns',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CombatActions') ? [] : ['className' => CombatActionsTable::class];
        $this->CombatActions = TableRegistry::getTableLocator()->get('CombatActions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CombatActions);

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
}
