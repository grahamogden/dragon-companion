<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharacterRacesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharacterRacesTable Test Case
 */
class CharacterRacesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CharacterRacesTable
     */
    public $CharacterRaces;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('CharacterRaces') ? [] : ['className' => CharacterRacesTable::class];
        $this->CharacterRaces = TableRegistry::getTableLocator()->get('CharacterRaces', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CharacterRaces);

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
}
