<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TimelineSegmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TimelineSegmentsTable Test Case
 */
class TimelineSegmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TimelineSegmentsTable
     */
    public $TimelineSegments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.timeline_segments',
        'app.users',
        'app.tags'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TimelineSegments') ? [] : ['className' => TimelineSegmentsTable::class];
        $this->TimelineSegments = TableRegistry::getTableLocator()->get('TimelineSegments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TimelineSegments);

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
