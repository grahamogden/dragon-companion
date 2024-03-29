<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlayerCharactersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlayerCharactersTable Test Case
 */
class PlayerCharactersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlayerCharactersTable
     */
    public $PlayerCharacters;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'app.PlayerCharacters',
        'app.Users',
        'app.Campaigns',
        'app.Participants',
        'app.CharacterClasses',
        'app.CharacterRaces',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlayerCharacters') ? [] : ['className' => PlayerCharactersTable::class];
        $this->PlayerCharacters = TableRegistry::getTableLocator()->get('PlayerCharacters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlayerCharacters);

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
