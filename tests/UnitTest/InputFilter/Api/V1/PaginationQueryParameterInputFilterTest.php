<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Policy;

use App\Error\Api\BadRequestError;
use App\InputFilter\Api\V1\PaginationQueryParameterInputFilter;
use Cake\Validation\Validator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PaginationQueryParameterInputFilterTest extends TestCase
{
    public const PARAM_PAGE = 'page';
    public const PARAM_LIMIT = 'limit';


    /*********************
     * constructor tests *
     *********************/

    public function testConstructorCallsValidatorIntegerForParams(): void
    {
        $validator = $this->mockValidator();

        $matcher = $this->exactly(2);
        $expected1 = self::PARAM_PAGE;
        $expected2 = self::PARAM_LIMIT;

        $validator->expects($matcher)
            ->method('integer')
            ->willReturnCallback(function (string $value) use ($matcher, $expected1, $expected2) {
                match ($matcher->numberOfInvocations()) {
                    1 =>  $this->assertEquals(expected: $expected1, actual: $value),
                    2 =>  $this->assertEquals(expected: $expected2, actual: $value),
                };
            });

        new PaginationQueryParameterInputFilter($validator);
    }

    public function testConstructorCallsValidatorNonNegativeIntegerForParams(): void
    {
        $validator = $this->mockValidator();

        $matcher = $this->exactly(2);
        $expected1 = self::PARAM_PAGE;
        $expected2 = self::PARAM_LIMIT;

        $validator->expects($matcher)
            ->method('nonNegativeInteger')
            ->willReturnCallback(function (string $value) use ($matcher, $expected1, $expected2) {
                match ($matcher->numberOfInvocations()) {
                    1 =>  $this->assertEquals(expected: $expected1, actual: $value),
                    2 =>  $this->assertEquals(expected: $expected2, actual: $value),
                };
            });

        new PaginationQueryParameterInputFilter($validator);
    }


    /*********************
     * validate tests *
     *********************/

    public static function dataProviderForValidateValidParams(): array
    {
        $default = [
            self::PARAM_PAGE => 1,
            self::PARAM_LIMIT => 1,
        ];

        return [
            'Default' => [
                'params' => $default,
            ],
            'Large page number' => [
                'params' => [...$default, self::PARAM_PAGE => 200000000],
            ],
            'String page number' => [
                'params' => [...$default, self::PARAM_PAGE => '50'],
            ],
            'Large limit number' => [
                'params' => [...$default, self::PARAM_LIMIT => 200000000],
            ],
            'String limit number' => [
                'params' => [...$default, self::PARAM_LIMIT => '50'],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForValidateValidParams
     */
    public function testValidateValidParams(array $params): void
    {
        $validator = new Validator();

        $objectUnderTest = new PaginationQueryParameterInputFilter($validator);

        $this->assertNull($objectUnderTest->validate($params));
    }

    public static function dataProviderForValidateThrowsBadRequestIfInvalidParams(): array
    {
        $default = [
            self::PARAM_PAGE => 1,
            self::PARAM_LIMIT => 1,
        ];

        return [
            'Alphabetic page number' => [
                'params' => [...$default, self::PARAM_PAGE => 'A'],
                'expected' => [
                    self::PARAM_PAGE => [
                        'integer' => 'The provided value must be an integer',
                        'nonNegativeInteger' => 'The provided value must be a non-negative integer',
                    ],
                ],
            ],
            'Boolean page number' => [
                'params' => [...$default, self::PARAM_PAGE => true],
                'expected' => [
                    self::PARAM_PAGE => [
                        'integer' => 'The provided value must be an integer',
                    ],
                ],
            ],
            'Alphabetic limit number' => [
                'params' => [...$default, self::PARAM_LIMIT => 'A'],
                'expected' => [
                    self::PARAM_LIMIT => [
                        'integer' => 'The provided value must be an integer',
                        'nonNegativeInteger' => 'The provided value must be a non-negative integer',
                    ],
                ],
            ],
            'Boolean limit number' => [
                'params' => [...$default, self::PARAM_LIMIT => true],
                'expected' =>   [
                    self::PARAM_LIMIT => [
                        'integer' => 'The provided value must be an integer',
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
        $validator = new Validator();

        $objectUnderTest = new PaginationQueryParameterInputFilter($validator);


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

    public static function dataProviderForFilterReturnsExpected(): array
    {
        return [
            'Integer page number' => [
                'params' => [self::PARAM_PAGE => 5],
                'expected' => [self::PARAM_PAGE => 5],
            ],
            'String page number' => [
                'params' => [self::PARAM_PAGE => '5'],
                'expected' => [self::PARAM_PAGE => 5],
            ],
            'Not set page' => [
                'params' => [],
                'expected' => [],
            ],
            'Integer limit number' => [
                'params' => [self::PARAM_LIMIT => 5],
                'expected' => [self::PARAM_LIMIT => 5],
            ],
            'String limit number' => [
                'params' => [self::PARAM_LIMIT => '5'],
                'expected' => [self::PARAM_LIMIT => 5],
            ],
            'Not set limit' => [
                'params' => [],
                'expected' => [],
            ],
            'Both page and limit' => [
                'params' => [
                    self::PARAM_PAGE => 5,
                    self::PARAM_LIMIT => 5
                ],
                'expected' => [
                    self::PARAM_PAGE => 5,
                    self::PARAM_LIMIT => 5
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForFilterReturnsExpected
     */
    public function testFilterReturnsExpected(array $params, array $expected): void
    {
        $objectUnderTest = new PaginationQueryParameterInputFilter($this->mockValidator());

        $this->assertSame(expected: $expected, actual: $objectUnderTest->filter($params));
    }

    public function testFilterDoesNotReturnUnknownParams(): void
    {
        $objectUnderTest = new PaginationQueryParameterInputFilter($this->mockValidator());

        $this->assertSame(expected: [], actual: $objectUnderTest->filter(['a' => true, 2 => 2]));
    }

    /************************
     ***** CREATE MOCKS *****
     ************************/

    public function mockValidator(): Validator|MockObject
    {
        $mock = $this->createMock(Validator::class);
        $mock->method('integer')
            ->willReturnSelf();
        $mock->method('nonNegativeInteger')
            ->willReturnSelf();

        return $mock;
    }
}
