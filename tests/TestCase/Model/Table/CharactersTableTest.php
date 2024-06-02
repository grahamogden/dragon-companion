<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharactersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharactersTable Test Case
 */
class CharactersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CharactersTable
     */
    protected $Characters;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Characters',
        'app.Users',
        'app.Campaigns',
        'app.Participants',
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
        $config = $this->getTableLocator()->exists('Characters') ? [] : ['className' => CharactersTable::class];
        $this->Characters = $this->getTableLocator()->get('Characters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Characters);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CharactersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CharactersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
