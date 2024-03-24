<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MonsterInstanceTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MonsterInstanceTypesTable Test Case
 */
class MonsterInstanceTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MonsterInstanceTypesTable
     */
    public $MonsterInstanceTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'app.MonsterInstanceTypes',
        'app.Monsters',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MonsterInstanceTypes') ? [] : ['className' => MonsterInstanceTypesTable::class];
        $this->MonsterInstanceTypes = TableRegistry::getTableLocator()->get('MonsterInstanceTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MonsterInstanceTypes);

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
