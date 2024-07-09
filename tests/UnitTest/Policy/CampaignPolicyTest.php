<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Policy;

use App\Model\Entity\Campaign;
use App\Model\Entity\User;
use App\Policy\CampaignPolicy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CampaignPolicyTest extends TestCase
{

    /****************
     * canAdd tests *
     ****************/

    public function testCanAddReturnsTrueIfUserLoggedIn(): void
    {
        $objectUnderTest = new CampaignPolicy();

        $this->assertTrue(
            $objectUnderTest->canAdd(
                $this->mockIdentityInterfaceUser(1),
                $this->mockCampaign()
            ),
        );
    }

    public function testCanAddReturnsFalseIfUserNotLoggedIn(): void
    {
        $objectUnderTest = new CampaignPolicy();

        $this->assertFalse(
            $objectUnderTest->canAdd(
                $this->mockIdentityInterfaceUser(),
                $this->mockCampaign()
            ),
        );
    }

    /************************
     ***** CREATE MOCKS *****
     ************************/

    public function mockIdentityInterfaceUser(?int $identifier = null): User|MockObject
    {
        $mock = $this->createMock(User::class);
        $mock->method('getIdentifier')
            ->willReturn($identifier);

        return $mock;
    }

    public function mockCampaign(): Campaign|MockObject
    {
        $mock = $this->createMock(Campaign::class);

        return $mock;
    }
}
