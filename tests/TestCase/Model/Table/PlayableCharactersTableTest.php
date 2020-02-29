<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlayableCharactersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlayableCharactersTable Test Case
 */
class PlayableCharactersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PlayableCharactersTable
     */
    public $PlayableCharacters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.playable_characters',
        'app.users',
        'app.participants',
        'app.character_classes',
        'app.character_races'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlayableCharacters') ? [] : ['className' => PlayableCharactersTable::class];
        $this->PlayableCharacters = TableRegistry::getTableLocator()->get('PlayableCharacters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlayableCharacters);

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
