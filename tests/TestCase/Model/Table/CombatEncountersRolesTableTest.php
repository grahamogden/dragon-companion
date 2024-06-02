<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CombatEncountersRolesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CombatEncountersRolesTable Test Case
 */
class CombatEncountersRolesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CombatEncountersRolesTable
     */
    protected $CombatEncountersRoles;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CombatEncountersRoles',
        'app.CombatEncounters',
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
        $config = $this->getTableLocator()->exists('CombatEncountersRoles') ? [] : ['className' => CombatEncountersRolesTable::class];
        $this->CombatEncountersRoles = $this->getTableLocator()->get('CombatEncountersRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CombatEncountersRoles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CombatEncountersRolesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CombatEncountersRolesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
