<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Campaign;
use App\Model\Table\CampaignsTable;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * App\Model\Table\CampaignsTable Test Case
 */
class CampaignsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var CampaignsTable
     */
    protected $Campaigns;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Alignments',
        'app.Campaigns',
        'app.CampaignUsers',
        'app.CombatEncounters',
        'app.PlayerCharacters',
        'app.TimelineSegments',
        'app.Users',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Campaigns') ? [] : ['className' => CampaignsTable::class];
        $this->Campaigns = $this->getTableLocator()->get('Campaigns', $config);
    }

    protected function tearDown(): void
    {
        unset($this->Campaigns);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @uses CampaignsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
        $validator = $this->mockValidator();

        $validator->expects(self::exactly(1))
            ->method('nonNegativeInteger')
            ->with('id');
        $validator->expects(self::exactly(1))
            ->method('allowEmptyString')
            ->with(['id', null, 'create'], ['synopsis']);

        $this->Campaigns->validationDefault($validator);
    }

    /**
     * Test findByIdWithUsers method
     *
     * @uses CampaignsTable::findOneByIdWithUsers()
     */
    public function testFindByIdWithUsersReturnsCampaignEntityResult(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'synopsis' => 'Lorem ipsum dolor sit amet',
        ];

        $result = $this->Campaigns->findOneByIdWithUsers(1);

        $this->assertInstanceOf(
            expected: Campaign::class,
            actual: $result
        );
        $this->assertSame(
            expected: $expected,
            actual: $result->toArray(),
        );
    }

    /**
     * Test findAllByUserId method
     *
     * @uses CampaignsTable::findByUserIdWithPermissionsCheck()
     */
    public function testFindAllByUserIdReturnsCampaignEntityResult(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'synopsis' => 'Lorem ipsum dolor sit amet',
        ];

        $result = $this->Campaigns->findByUserIdWithPermissionsCheck(1)->toArray();

        $this->assertInstanceOf(
            expected: Campaign::class,
            actual: $result[0],
        );
        $this->assertSame(
            expected: $expected,
            actual: $result[0]->toArray(),
        );
    }

    private function mockValidator(): Validator&MockObject
    {
        $mock = $this->createMock(Validator::class);
        $mock->method('nonNegativeInteger')
            ->willReturnSelf();
        $mock->method('allowEmptyString')
            ->willReturnSelf();
        $mock->method('scalar')
            ->willReturnSelf();
        $mock->method('maxLength')
            ->willReturnSelf();
        $mock->method('notEmptyString')
            ->willReturnSelf();

        return $mock;
    }
}
