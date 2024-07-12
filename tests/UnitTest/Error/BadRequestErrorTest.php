<?php

declare(strict_types=1);

namespace Tests\UnitTest\Error;

use App\Error\Api\BadRequestError;
use PHPUnit\Framework\TestCase;

class BadRequestErrorTest extends TestCase
{
    /********************
     * getMessage tests *
     ********************/

    public function testTooStringIncludesMessage(): void
    {
        $message = 'Hello there';

        $objectUnderTest = new BadRequestError(message: $message);

        $this->assertSame(
            expected: $message,
            actual: $objectUnderTest->getMessage(),
        );
    }
}
