<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\V1;

use App\Controller\Api\V1\CampaignController;
use App\Test\Service\Request\Header\Authentication\AuthenticationTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use App\Test\Service\Request\Header\HeaderTrait;

/**
 * App\Controller\Api\V1\CampaignController Test Case
 *
 * @uses \App\Controller\Api\V1\CampaignController
 */
class CampaignControllerTest extends TestCase
{
    use IntegrationTestTrait;
    use AuthenticationTrait;
    use HeaderTrait;

    // private string $authToken;

    protected array $fixtures = [
        'app.Users',
        'app.Campaigns',
        'app.CampaignPermissions',
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpBearerToken();
        $this->setUpRequestHeaders();
    }

    public function testIndex(): void
    {
        $this->get('/api/v1/campaigns');

        $expected = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'synopsis' => 'Lorem ipsum dolor sit amet',
            ]
        ];

        $this->assertEquals(
            expected: $expected,
            actual: json_decode((string) $this->_response->getBody(), true),
        );
    }

    public function testViewFound(): void
    {
        $this->get('/api/v1/campaigns/1');

        $expected = [
            'id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'synopsis' => 'Lorem ipsum dolor sit amet',
        ];

        $this->assertEquals(
            expected: $expected,
            actual: json_decode((string) $this->_response->getBody(), true),
        );
    }

    public function testViewIdNotFound(): void
    {
        $this->get('/api/v1/campaigns/20000');

        $expected = [
            'message' => 'Campaign 20000 not found',
        ];

        $this->assertEquals(
            expected: $expected,
            actual: json_decode((string) $this->_response->getBody(), true),
        );
    }
}
