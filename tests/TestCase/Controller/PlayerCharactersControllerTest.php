<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PlayerCharactersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\PlayerCharactersController Test Case
 *
 * @uses \App\Controller\PlayerCharactersController
 */
class PlayerCharactersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlayerCharacters',
        'app.Users',
        'app.CharacterClasses',
        'app.CharacterRaces',
        'app.Participants',
        'app.CharacterClassesPlayerCharacters',
        'app.CharacterRacesPlayerCharacters',
        'app.ParticipantsPlayerCharacters',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
