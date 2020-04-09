<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConditionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConditionsTable Test Case
 */
class ConditionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConditionsTable
     */
    public $Conditions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Conditions',
        'app.CombatTurns',
        'app.Participants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Conditions') ? [] : ['className' => ConditionsTable::class];
        $this->Conditions = TableRegistry::getTableLocator()->get('Conditions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Conditions);

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
