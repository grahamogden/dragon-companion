<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

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
     * @uses CampaignsTable::findByIdWithUsers()
     */
    public function testFindByIdWithUsers(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findAllByUserId method
     *
     * @uses CampaignsTable::findAllByUserId()
     */
    public function testFindAllByUserId(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
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
