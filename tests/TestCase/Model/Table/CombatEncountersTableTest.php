<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CombatEncountersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CombatEncountersTable Test Case
 */
class CombatEncountersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CombatEncountersTable
     */
    protected $CombatEncounters;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CombatEncounters',
        'app.Users',
        'app.Campaigns',
        'app.CombatTurns',
        'app.Participants',
        'app.Roles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CombatEncounters') ? [] : ['className' => CombatEncountersTable::class];
        $this->CombatEncounters = $this->getTableLocator()->get('CombatEncounters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CombatEncounters);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CombatEncountersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CombatEncountersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
