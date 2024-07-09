<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Policy;

use App\Model\Entity\Species;
use App\Model\Entity\User;
use App\Policy\SpeciesPolicy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SpeciesPolicyTest extends TestCase
{

    /****************
     * canAdd tests *
     ****************/

    public function testCanAddReturnsTrueIfUserLoggedIn(): void
    {
        $objectUnderTest = new SpeciesPolicy();

        $this->assertTrue(
            $objectUnderTest->canAdd(
                $this->mockIdentityInterfaceUser(1),
                $this->Species()
            ),
        );
    }

    public function testCanAddReturnsFalseIfUserNotLoggedIn(): void
    {
        $objectUnderTest = new SpeciesPolicy();

        $this->assertFalse(
            $objectUnderTest->canAdd(
                $this->mockIdentityInterfaceUser(),
                $this->Species()
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

    public function Species(): Species|MockObject
    {
        $mock = $this->createMock(Species::class);

        return $mock;
    }
}
