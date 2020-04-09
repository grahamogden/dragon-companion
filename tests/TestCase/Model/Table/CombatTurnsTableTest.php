<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CombatTurnsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CombatTurnsTable Test Case
 */
class CombatTurnsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CombatTurnsTable
     */
    public $CombatTurns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CombatTurns',
        'app.CombatEncounters',
        'app.Participants',
        'app.Conditions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CombatTurns') ? [] : ['className' => CombatTurnsTable::class];
        $this->CombatTurns = TableRegistry::getTableLocator()->get('CombatTurns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CombatTurns);

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
