<?php

declare(strict_types=1);

namespace Tests\UnitTest\Error;

use App\Error\Api\NotFoundError;
use PHPUnit\Framework\TestCase;

class NotFoundErrorTest extends TestCase
{
    /********************
     * getMessage tests *
     ********************/

    public function testTooStringIncludesMessage(): void
    {
        $message = 'Hello there';

        $objectUnderTest = new NotFoundError(message: $message);

        $this->assertSame(
            expected: $message,
            actual: $objectUnderTest->getMessage(),
        );
    }
}
