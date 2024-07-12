<?php

declare(strict_types=1);

namespace Tests\UnitTest\Error;

use App\Error\Api\ForbiddenError;
use PHPUnit\Framework\TestCase;

class ForbiddenErrorTest extends TestCase
{
    /********************
     * getMessage tests *
     ********************/

    public function testTooStringIncludesMessage(): void
    {
        $message = 'Hello there';

        $objectUnderTest = new ForbiddenError(message: $message);

        $this->assertSame(
            expected: $message,
            actual: $objectUnderTest->getMessage(),
        );
    }
}
