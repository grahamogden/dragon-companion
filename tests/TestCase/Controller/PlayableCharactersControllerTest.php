<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PlayableCharactersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\PlayableCharactersController Test Case
 */
class PlayableCharactersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.playable_characters',
        'app.users',
        'app.participants',
        'app.character_classes',
        'app.character_races',
        'app.character_classes_playable_characters',
        'app.character_races_playable_characters'
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
