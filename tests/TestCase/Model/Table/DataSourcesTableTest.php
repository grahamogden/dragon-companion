<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DataSourcesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DataSourcesTable Test Case
 */
class DataSourcesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DataSourcesTable
     */
    public $DataSources;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'app.DataSources',
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
        $config = TableRegistry::getTableLocator()->exists('DataSources') ? [] : ['className' => DataSourcesTable::class];
        $this->DataSources = TableRegistry::getTableLocator()->get('DataSources', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DataSources);

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
