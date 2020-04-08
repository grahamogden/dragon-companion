<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConditionsParticipantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConditionsParticipantsTable Test Case
 */
class ConditionsParticipantsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConditionsParticipantsTable
     */
    public $ConditionsParticipants;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ConditionsParticipants',
        'app.Conditions',
        'app.Participants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ConditionsParticipants') ? [] : ['className' => ConditionsParticipantsTable::class];
        $this->ConditionsParticipants = TableRegistry::getTableLocator()->get('ConditionsParticipants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ConditionsParticipants);

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
