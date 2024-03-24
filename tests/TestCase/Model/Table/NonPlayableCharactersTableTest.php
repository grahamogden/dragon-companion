<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NonPlayableCharactersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NonPlayableCharactersTable Test Case
 */
class NonPlayableCharactersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NonPlayableCharactersTable
     */
    public $NonPlayableCharacters;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'app.NonPlayableCharacters',
        'app.Alignments',
        'app.Users',
        'app.TimelineSegments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('NonPlayableCharacters') ? [] : ['className' => NonPlayableCharactersTable::class];
        $this->NonPlayableCharacters = TableRegistry::getTableLocator()->get('NonPlayableCharacters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NonPlayableCharacters);

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
