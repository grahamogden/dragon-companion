<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Campaign;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Campaign Test Case
 */
class CampaignTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Campaign
     */
    protected $Campaign;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Campaign = new Campaign();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Campaign);

        parent::tearDown();
    }

    /**
     * Test getId method
     *
     * @return void
     * @uses \App\Model\Entity\Campaign::getId()
     */
    public function testGetId(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test setName method
     *
     * @return void
     * @uses \App\Model\Entity\Campaign::setName()
     */
    public function testSetName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getName method
     *
     * @return void
     * @uses \App\Model\Entity\Campaign::getName()
     */
    public function testGetName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test setSynopsis method
     *
     * @return void
     * @uses \App\Model\Entity\Campaign::setSynopsis()
     */
    public function testSetSynopsis(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getSynopsis method
     *
     * @return void
     * @uses \App\Model\Entity\Campaign::getSynopsis()
     */
    public function testGetSynopsis(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test addUser method
     *
     * @return void
     * @uses \App\Model\Entity\Campaign::addUser()
     */
    public function testAddUser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
