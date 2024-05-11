<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\V1;

use App\Controller\Api\V1\CampaignController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
// use PHPUnit\Framework\TestCase;

/**
 * App\Controller\Api\V1\CampaignController Test Case
 *
 * @uses \App\Controller\Api\V1\CampaignController
 */
class CampaignControllerTest extends TestCase
{
    use IntegrationTestTrait;
    private string $authToken;

    protected array $fixtures = [
        'app.Campaigns',
    ];

    public function testIndex(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6ImUyYjIyZmQ0N2VkZTY4MmY2OGZhY2NmZTdjNGNmNWIxMWIxMmI1NGIiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vZHJhZ29uLWNvbXBhbmlvbi1lZDNmMCIsImF1ZCI6ImRyYWdvbi1jb21wYW5pb24tZWQzZjAiLCJhdXRoX3RpbWUiOjE3MTQ5MTkwNTcsInVzZXJfaWQiOiI5SGt3c0hCQjN1aEVpdzlmTGVWRGsyOWgxQmYyIiwic3ViIjoiOUhrd3NIQkIzdWhFaXc5ZkxlVkRrMjloMUJmMiIsImlhdCI6MTcxNTQxOTA3MiwiZXhwIjoxNzE1NDIyNjcyLCJlbWFpbCI6ImRyYWdvbi5jb21wYW5pb24uYXBwQGdtYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwiZmlyZWJhc2UiOnsiaWRlbnRpdGllcyI6eyJlbWFpbCI6WyJkcmFnb24uY29tcGFuaW9uLmFwcEBnbWFpbC5jb20iXX0sInNpZ25faW5fcHJvdmlkZXIiOiJwYXNzd29yZCJ9fQ.bAF2ogUF5DxaOSy5bu2HqLUqjtZlkL5tL0HDysfCA-IqXOwdAs-z8-VF5dePWMYZWvckrMcOqwwQCeHiZ0HMerLki3Y3ZBsz3NLzdKTSymf-XrLZbrIfqIB1-rdTxJMQJ7rgS0trZ98AnTIf8t8iFM5_0EPZ1chaiokZfOE3mxog5h1pgLm-YIvxwApAH9SDSjflsjw79zot8HrKYbSWW8SHJrKMVXj0IUJAj8e46TbG6EWHPM_jel5ZyUYBY8L288qB8tC4gRGWAkCKuvTL_eWmtWAMSp7qhkK-dTtG4EWc4SAzMI_M3dF0AoXx3Dlib8c_rBLPPivgpSsO3kGTfQ',
            ],
        ]);
        $this->get('/api/v1/campaigns');

        // $this->assertResponseOk();
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
