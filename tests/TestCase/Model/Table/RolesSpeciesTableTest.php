<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RolesSpeciesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RolesSpeciesTable Test Case
 */
class RolesSpeciesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RolesSpeciesTable
     */
    protected $RolesSpecies;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.RolesSpecies',
        'app.Roles',
        'app.Species',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RolesSpecies') ? [] : ['className' => RolesSpeciesTable::class];
        $this->RolesSpecies = $this->getTableLocator()->get('RolesSpecies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RolesSpecies);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RolesSpeciesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RolesSpeciesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
