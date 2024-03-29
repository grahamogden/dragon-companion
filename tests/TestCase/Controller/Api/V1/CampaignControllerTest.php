<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\V1;

use App\Controller\Api\V1\CampaignController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Api\V1\CampaignController Test Case
 *
 * @uses \App\Controller\Api\V1\CampaignController
 */
class CampaignControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Campaigns',
    ];

    public function setUp(): void
    {
        $this->configRequest([
            'headers' => ['Accept' => 'application/json'],
        ]);
    }

    public function testIndex(): void
    {
        $this->get('/api/v1/campaigns');

        $this->assertResponseOk();
        $expected = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'synopsis' => 'Lorem ipsum dolor sit amet',
            ]
        ];
        $this->assertEquals(
            json_encode($expected, JSON_PRETTY_PRINT),
            (string) $this->_response->getBody()
        );
    }
}
