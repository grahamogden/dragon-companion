<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharacterRacesPlayableCharactersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharacterRacesPlayableCharactersTable Test Case
 */
class CharacterRacesPlayableCharactersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CharacterRacesPlayableCharactersTable
     */
    public $CharacterRacesPlayableCharacters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.character_races_playable_characters',
        'app.character_races',
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
        $config = TableRegistry::getTableLocator()->exists('CharacterRacesPlayableCharacters') ? [] : ['className' => CharacterRacesPlayableCharactersTable::class];
        $this->CharacterRacesPlayableCharacters = TableRegistry::getTableLocator()->get('CharacterRacesPlayableCharacters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CharacterRacesPlayableCharacters);

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
