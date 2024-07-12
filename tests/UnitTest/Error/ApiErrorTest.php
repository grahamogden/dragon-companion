<?php

declare(strict_types=1);

namespace Tests\UnitTest\Error;

use App\Error\Api\ApiError;
use PHPUnit\Framework\TestCase;

class ApiErrorTest extends TestCase
{

    /****************
     * getErrors tests *
     ****************/

    public function testGetErrorsReturnsErrors(): void
    {
        $errors = [
            'a' => true,
            2 => 2,
        ];

        $objectUnderTest = new ApiError(message: '', errors: $errors);

        $this->assertSame(
            expected: $errors,
            actual: $objectUnderTest->getErrors(),
        );
    }

    /****************
     * toString tests *
     ****************/

    public function testTooStringIncludesMessage(): void
    {
        $message = 'Hello there';

        $objectUnderTest = new ApiError(message: $message);

        $this->assertSame(
            expected: $message,
            actual: json_decode($objectUnderTest->__toString(), true)['message'],
        );
    }

    public function testTooStringIncludesErrorsIfSet(): void
    {
        $errors = [
            'a' => true,
            2 => 2,
        ];

        $objectUnderTest = new ApiError(message: '', errors: $errors);

        $this->assertSame(
            expected: $errors,
            actual: json_decode($objectUnderTest->__toString(), true)['errors'],
        );
    }

    public function testTooStringDoesNotIncludeErrorsIfNotSet(): void
    {
        $objectUnderTest = new ApiError(message: '');

        $this->assertFalse(
            condition: isset(json_decode($objectUnderTest->__toString(), true)['errors']),
        );
    }

    public function testTooStringIncludesStackTraceIfDebugEnabled(): void
    {
        $objectUnderTest = new ApiError(message: '');

        $this->assertSame(
            expected: '/var/www/dragon-companion/tests/UnitTest/Error/ApiErrorTest.php',
            actual: json_decode($objectUnderTest->__toString(), true)['file'],
        );

        $this->assertSame(
            expected: 74,
            actual: json_decode($objectUnderTest->__toString(), true)['line'],
        );

        $this->assertTrue(
            condition: isset(json_decode($objectUnderTest->__toString(), true)['trace']),
        );

        $this->assertIsArray(
            actual: json_decode($objectUnderTest->__toString(), true)['trace'],
        );
    }
}
