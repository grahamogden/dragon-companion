<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Policy;

use App\Error\Api\BadRequestError;
use App\InputFilter\Api\V1\Timelines\ViewQueryParameterInputFilter;
use App\Validation\CustomValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ViewQueryParameterInputFilterTest extends TestCase
{
    public const PARAM_INCLUDE_CHILDREN = 'includeChildren';


    /*********************
     * constructor tests *
     *********************/

    public function testConstructorCallsValidatorIntegerForParams(): void
    {
        $validator = $this->mockValidator();

        $matcher = $this->exactly(1);
        $expected1 = self::PARAM_INCLUDE_CHILDREN;

        $validator->expects($matcher)
            ->method('extendedBoolean')
            ->willReturnCallback(function (string $value) use ($matcher, $expected1) {
                match ($matcher->numberOfInvocations()) {
                    1 =>  $this->assertEquals(expected: $expected1, actual: $value),
                };
            });

        new ViewQueryParameterInputFilter(
            validator: $validator,
        );
    }


    /*********************
     * validate tests *
     *********************/

    public static function dataProviderForValidateValidParams(): array
    {
        $default = [
            self::PARAM_INCLUDE_CHILDREN => 1,
        ];

        return [
            'Default = ' . var_export($default, true) => [
                'params' => $default,
            ],
            'includeChildren = 1' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 1],
            ],
            'includeChildren = "1"' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => '1'],
            ],
            'includeChildren = true' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => true],
            ],
            'includeChildren = "true' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 'true'],
            ],
            'includeChildren = 0' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 0],
            ],
            'includeChildren = "0"' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => '0'],
            ],
            'includeChildren = false' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => false],
            ],
            'includeChildren = "false' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 'false'],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForValidateValidParams
     */
    public function testValidateValidParams(array $params): void
    {
        $validator = new CustomValidator();

        $objectUnderTest = new ViewQueryParameterInputFilter(
            validator: $validator,
        );

        $this->assertNull($objectUnderTest->validate($params));
    }

    public static function dataProviderForValidateThrowsBadRequestIfInvalidParams(): array
    {
        $default = [
            self::PARAM_INCLUDE_CHILDREN => 1,
        ];

        return [
            'Alphabetic includeChildren = "A"' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 'A'],
                'expected' => [
                    self::PARAM_INCLUDE_CHILDREN => [
                        'extendedBoolean' => 'The provided value must be a boolean (true, "true", 1, "1", false, "false", 0, "0")',
                    ],
                ],
            ],
            'Numeric non-boolean includeChildren = 5' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 5],
                'expected' => [
                    self::PARAM_INCLUDE_CHILDREN => [
                        'extendedBoolean' => 'The provided value must be a boolean (true, "true", 1, "1", false, "false", 0, "0")',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForValidateThrowsBadRequestIfInvalidParams
     */
    public function testValidateThrowsBadRequestIfInvalidParams(array $params, array $expected): void
    {
        $validator = new CustomValidator();

        $objectUnderTest = new ViewQueryParameterInputFilter(
            validator: $validator,
        );

        try {
            $this->assertNull($objectUnderTest->validate($params));
        } catch (BadRequestError $exception) {
            $this->assertInstanceOf(expected: BadRequestError::class, actual: $exception);
            $this->assertSame(expected: $expected, actual: $exception->getErrors());
            return;
        }
        $this->fail();
    }


    /****************
     * filter tests *
     ****************/

    public static function dataProviderFilterReturnsvalidatorFilterExtendedBooleanResult(): array
    {
        return [
            'false' => [
                'params' => [self::PARAM_INCLUDE_CHILDREN => 0],
                'expected' => [self::PARAM_INCLUDE_CHILDREN => false],
            ],
            'true' => [
                'params' => [self::PARAM_INCLUDE_CHILDREN => 1],
                'expected' => [self::PARAM_INCLUDE_CHILDREN => true],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderFilterReturnsvalidatorFilterExtendedBooleanResult
     */
    public function testFilterReturnsvalidatorFilterExtendedBooleanResult(array $params, array $expected): void
    {
        $objectUnderTest = new ViewQueryParameterInputFilter(
            validator: $this->mockValidator($expected[self::PARAM_INCLUDE_CHILDREN]),
        );

        $this->assertSame(expected: $expected, actual: $objectUnderTest->filter($params));
    }

    /************************
     ***** CREATE MOCKS *****
     ************************/

    public function mockValidator(bool $filterExtendedBooleanResponse = true): CustomValidator|MockObject
    {
        $mock = $this->createMock(CustomValidator::class);
        $mock->method('extendedBoolean')
            ->willReturnSelf();
        $mock->method('filterExtendedBoolean')
            ->willReturn($filterExtendedBooleanResponse);

        return $mock;
    }
}
