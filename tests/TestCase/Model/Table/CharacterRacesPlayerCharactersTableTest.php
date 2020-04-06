<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharacterRacesPlayerCharactersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharacterRacesPlayerCharactersTable Test Case
 */
class CharacterRacesPlayerCharactersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CharacterRacesPlayerCharactersTable
     */
    public $CharacterRacesPlayerCharacters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CharacterRacesPlayerCharacters',
        'app.CharacterRaces',
        'app.PlayerCharacters',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CharacterRacesPlayerCharacters') ? [] : ['className' => CharacterRacesPlayerCharactersTable::class];
        $this->CharacterRacesPlayerCharacters = TableRegistry::getTableLocator()->get('CharacterRacesPlayerCharacters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CharacterRacesPlayerCharacters);

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
