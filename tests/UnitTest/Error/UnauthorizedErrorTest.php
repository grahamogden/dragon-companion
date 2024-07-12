<?php

declare(strict_types=1);

namespace Tests\UnitTest\Error;

use App\Error\Api\UnauthorizedError;
use PHPUnit\Framework\TestCase;

class UnauthorizedErrorTest extends TestCase
{
    /********************
     * getMessage tests *
     ********************/

    public function testTooStringIncludesMessage(): void
    {
        $message = 'Hello there';

        $objectUnderTest = new UnauthorizedError(message: $message);

        $this->assertSame(
            expected: $message,
            actual: $objectUnderTest->getMessage(),
        );
    }
}
