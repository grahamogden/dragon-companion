<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharactersRolesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharactersRolesTable Test Case
 */
class CharactersRolesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CharactersRolesTable
     */
    protected $CharactersRoles;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CharactersRoles',
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
        $config = $this->getTableLocator()->exists('CharactersRoles') ? [] : ['className' => CharactersRolesTable::class];
        $this->CharactersRoles = $this->getTableLocator()->get('CharactersRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CharactersRoles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CharactersRolesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CharactersRolesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
