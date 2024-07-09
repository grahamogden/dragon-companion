<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharactersSpeciesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharactersSpeciesTable Test Case
 */
class CharactersSpeciesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CharactersSpeciesTable
     */
    protected $CharactersSpecies;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CharactersSpecies',
        'app.Characters',
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
        $config = $this->getTableLocator()->exists('CharactersSpecies') ? [] : ['className' => CharactersSpeciesTable::class];
        $this->CharactersSpecies = $this->getTableLocator()->get('CharactersSpecies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CharactersSpecies);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CharactersSpeciesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CharactersSpeciesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
