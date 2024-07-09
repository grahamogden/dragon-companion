<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CombatTurnsTable;
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
    protected $CombatTurns;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CombatTurns',
        'app.CombatEncounters',
        'app.Participants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CombatTurns') ? [] : ['className' => CombatTurnsTable::class];
        $this->CombatTurns = $this->getTableLocator()->get('CombatTurns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CombatTurns);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CombatTurnsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CombatTurnsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
