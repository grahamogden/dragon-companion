<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharacterClassesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharacterClassesTable Test Case
 */
class CharacterClassesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CharacterClassesTable
     */
    public $CharacterClasses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CharacterClasses',
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
        $config = TableRegistry::getTableLocator()->exists('CharacterClasses') ? [] : ['className' => CharacterClassesTable::class];
        $this->CharacterClasses = TableRegistry::getTableLocator()->get('CharacterClasses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CharacterClasses);

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
