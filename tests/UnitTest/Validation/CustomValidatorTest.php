<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Validation;

use App\Error\Api\BadRequestError;
use App\InputFilter\Api\V1\PaginationQueryParameterInputFilter;
use App\InputFilter\Api\V1\Timelines\ViewQueryParameterInputFilter;
use App\Validation\CustomValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CustomValidatorTest extends TestCase
{
    public const PARAM_INCLUDE_CHILDREN = 'includeChildren';


    /******************
     * validate tests *
     ******************/

    public static function dataProviderForValidateValidParams(): array
    {
        return [
            'param = 1' => [
                'params' => ['param' => 1],
            ],
            'param = "1"' => [
                'params' => ['param' => '1'],
            ],
            'param = true' => [
                'params' => ['param' => true],
            ],
            'param = "true' => [
                'params' => ['param' => 'true'],
            ],
            'param = 0' => [
                'params' => ['param' => 0],
            ],
            'param = "0"' => [
                'params' => ['param' => '0'],
            ],
            'param = false' => [
                'params' => ['param' => false],
            ],
            'param = "false' => [
                'params' => ['param' => 'false'],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForValidateValidParams
     */
    public function testValidateValidParams(array $params): void
    {
        $objectUnderTest = new CustomValidator();

        $objectUnderTest->extendedBoolean('param');

        $this->assertEmpty(actual: $objectUnderTest->validate($params));
    }

    public static function dataProviderForValidateThrowsBadRequestIfInvalidParams(): array
    {
        return [
            'Alphabetic param = "A"' => [
                'params' => ['param' => 'A'],
                'expected' => [
                    'param' => ['extendedBoolean' => 'The provided value must be a boolean (true, "true", 1, "1", false, "false", 0, "0")',]
                ],
            ],
            'Numeric non-boolean param = 5' => [
                'params' => ['param' => 5],
                'expected' => [
                    'param' => ['extendedBoolean' => 'The provided value must be a boolean (true, "true", 1, "1", false, "false", 0, "0")',]
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForValidateThrowsBadRequestIfInvalidParams
     */
    public function testValidateThrowsBadRequestIfInvalidParams(array $params, array $expected): void
    {
        $objectUnderTest = new CustomValidator();

        $objectUnderTest->extendedBoolean('param');

        $actual = $objectUnderTest->validate($params);
        $this->assertNotEmpty(actual: $actual);
        $this->assertSame(expected: $expected, actual: $actual);
    }


    /*******************************
     * filterExtendedBoolean tests *
     *******************************/

    public static function dataProviderForFilterExtendedBoolean(): array
    {
        return [
            'param = 1' => [
                'param' => 1,
                'expected' => true,
            ],
            'param = "1"' => [
                'param' => '1',
                'expected' => true,
            ],
            'param = true' => [
                'param' => true,
                'expected' => true,
            ],
            'param = "true' => [
                'param' => 'true',
                'expected' => true,
            ],
            'param = 0' => [
                'param' => 0,
                'expected' => false,
            ],
            'param = "0"' => [
                'param' => '0',
                'expected' => false,
            ],
            'param = false' => [
                'param' => false,
                'expected' => false,
            ],
            'param = "false"' => [
                'param' => 'false',
                'expected' => false,
            ],
            'param = "a"' => [
                'param' => 'a',
                'expected' => false,
            ],
            'param = -1' => [
                'param' => -1,
                'expected' => false,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForFilterExtendedBoolean
     */
    public function testFilterExtendedBoolean($param, bool $expected): void
    {
        $objectUnderTest = new CustomValidator();

        $this->assertSame(expected: $expected, actual: $objectUnderTest->filterExtendedBoolean($param));
    }
}
