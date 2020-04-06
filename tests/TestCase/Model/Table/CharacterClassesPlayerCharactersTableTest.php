<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharacterClassesPlayerCharactersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharacterClassesPlayerCharactersTable Test Case
 */
class CharacterClassesPlayerCharactersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CharacterClassesPlayerCharactersTable
     */
    public $CharacterClassesPlayerCharacters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.character_classes_player_characters',
        'app.character_classes',
        'app.player_characters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CharacterClassesPlayerCharacters') ? [] : ['className' => CharacterClassesPlayerCharactersTable::class];
        $this->CharacterClassesPlayerCharacters = TableRegistry::getTableLocator()->get('CharacterClassesPlayerCharacters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CharacterClassesPlayerCharacters);

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
