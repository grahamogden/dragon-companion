<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CampaignsRolesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CampaignsRolesTable Test Case
 */
class CampaignsRolesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CampaignsRolesTable
     */
    protected $CampaignsRoles;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CampaignsRoles',
        'app.Campaigns',
        'app.Roles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CampaignsRoles') ? [] : ['className' => CampaignsRolesTable::class];
        $this->CampaignsRoles = $this->getTableLocator()->get('CampaignsRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CampaignsRoles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CampaignsRolesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CampaignsRolesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
