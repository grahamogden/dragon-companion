<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharacterClassesPlayableCharactersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharacterClassesPlayableCharactersTable Test Case
 */
class CharacterClassesPlayableCharactersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CharacterClassesPlayableCharactersTable
     */
    public $CharacterClassesPlayableCharacters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.character_classes_playable_characters',
        'app.character_classes',
        'app.playable_characters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CharacterClassesPlayableCharacters') ? [] : ['className' => CharacterClassesPlayableCharactersTable::class];
        $this->CharacterClassesPlayableCharacters = TableRegistry::getTableLocator()->get('CharacterClassesPlayableCharacters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CharacterClassesPlayableCharacters);

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
