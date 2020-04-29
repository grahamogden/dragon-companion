<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlignmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AlignmentsTable Test Case
 */
class AlignmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AlignmentsTable
     */
    public $Alignments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Alignments',
        'app.Monsters',
        'app.NonPlayableCharacters',
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
        $config = TableRegistry::getTableLocator()->exists('Alignments') ? [] : ['className' => AlignmentsTable::class];
        $this->Alignments = TableRegistry::getTableLocator()->get('Alignments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Alignments);

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
