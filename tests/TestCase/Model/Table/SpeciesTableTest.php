<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SpeciesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SpeciesTable Test Case
 */
class SpeciesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SpeciesTable
     */
    protected $Species;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Species',
        'app.Campaigns',
        'app.Users',
        'app.Characters',
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
        $config = $this->getTableLocator()->exists('Species') ? [] : ['className' => SpeciesTable::class];
        $this->Species = $this->getTableLocator()->get('Species', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Species);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SpeciesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SpeciesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
