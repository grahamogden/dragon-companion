<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Policy;

use App\Model\Entity\Timeline;
use App\Model\Entity\User;
use App\Policy\TimelinePolicy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TimelinePolicyTest extends TestCase
{

    /****************
     * canAdd tests *
     ****************/

    public function testCanAddReturnsTrueIfUserLoggedIn(): void
    {
        $objectUnderTest = new TimelinePolicy();

        $this->assertTrue(
            $objectUnderTest->canAdd(
                $this->mockIdentityInterfaceUser(1),
                $this->mockTimeline()
            ),
        );
    }

    public function testCanAddReturnsFalseIfUserNotLoggedIn(): void
    {
        $objectUnderTest = new TimelinePolicy();

        $this->assertFalse(
            $objectUnderTest->canAdd(
                $this->mockIdentityInterfaceUser(),
                $this->mockTimeline()
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

    public function mockTimeline(): Timeline|MockObject
    {
        $mock = $this->createMock(Timeline::class);

        return $mock;
    }
}
