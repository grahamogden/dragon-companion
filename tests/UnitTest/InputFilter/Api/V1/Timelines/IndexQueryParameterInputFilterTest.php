<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Policy;

use App\Error\Api\BadRequestError;
use App\InputFilter\Api\V1\PaginationQueryParameterInputFilter;
use App\InputFilter\Api\V1\Timelines\IndexQueryParameterInputFilter;
use App\Validation\CustomValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IndexQueryParameterInputFilterTest extends TestCase
{
    public const PARAM_LEVEL = 'level';
    public const PARAM_INCLUDE_CHILDREN = 'includeChildren';


    /*********************
     * constructor tests *
     *********************/

    public function testConstructorCallsValidatorIntegerForParams(): void
    {
        $validator = $this->mockValidator();

        $matcher = $this->exactly(1);
        $expected1 = self::PARAM_LEVEL;

        $validator->expects($matcher)
            ->method('integer')
            ->willReturnCallback(function (string $value) use ($matcher, $expected1) {
                match ($matcher->numberOfInvocations()) {
                    1 =>  $this->assertEquals(expected: $expected1, actual: $value),
                };
            });

        new IndexQueryParameterInputFilter(
            validator: $validator,
            paginationQueryParameterInputFilter: $this->mockPaginationQueryParameterInputFilter()
        );
    }

    public function testConstructorCallsValidatorNonNegativeIntegerForParams(): void
    {
        $validator = $this->mockValidator();

        $matcher = $this->exactly(1);
        $expected1 = self::PARAM_LEVEL;

        $validator->expects($matcher)
            ->method('nonNegativeInteger')
            ->willReturnCallback(function (string $value) use ($matcher, $expected1) {
                match ($matcher->numberOfInvocations()) {
                    1 =>  $this->assertEquals(expected: $expected1, actual: $value),
                };
            });

        new IndexQueryParameterInputFilter(
            validator: $validator,
            paginationQueryParameterInputFilter: $this->mockPaginationQueryParameterInputFilter()
        );
    }

    public function testConstructorCallsValidatorExtendedBooleanForParams(): void
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

        new IndexQueryParameterInputFilter(
            validator: $validator,
            paginationQueryParameterInputFilter: $this->mockPaginationQueryParameterInputFilter()
        );
    }


    /*********************
     * validate tests *
     *********************/

    public function testValidateCallsPaginationQueryParameterInputFilterValidateWithParams(): void
    {
        $paginationQueryParameterInputFilter = $this->mockPaginationQueryParameterInputFilter();
        $params = ['a' => true, 2 => 2];

        $objectUnderTest = new IndexQueryParameterInputFilter(
            validator: $this->mockValidator(),
            paginationQueryParameterInputFilter: $paginationQueryParameterInputFilter
        );

        $paginationQueryParameterInputFilter->expects($this->exactly(1))
            ->method('validate')
            ->with($params);

        $objectUnderTest->validate($params);
    }

    public static function dataProviderForValidateValidParams(): array
    {
        $default = [
            self::PARAM_LEVEL => 1,
            self::PARAM_INCLUDE_CHILDREN => true,
        ];

        return [
            'Default' => [
                'params' => $default,
            ],
            'Large level' => [
                'params' => [...$default, self::PARAM_LEVEL => 20000000],
            ],
            'includeChildren = true' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => true],
            ],
            'includeChildren = false' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => false],
            ],
            'includeChildren = "true"' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 'true'],
            ],
            'includeChildren = "false"' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 'false'],
            ],
            'includeChildren = 1' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 1],
            ],
            'includeChildren = 0' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 0],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForValidateValidParams
     */
    public function testValidateValidParams(array $params): void
    {
        $validator = new CustomValidator();

        $objectUnderTest = new IndexQueryParameterInputFilter(
            validator: $validator,
            paginationQueryParameterInputFilter: $this->mockPaginationQueryParameterInputFilter()
        );

        $this->assertNull($objectUnderTest->validate($params));
    }

    public static function dataProviderForValidateThrowsBadRequestIfInvalidParams(): array
    {
        $default = [
            self::PARAM_LEVEL => 1,
            self::PARAM_INCLUDE_CHILDREN => true,
        ];

        return [
            'Alphabetic page number' => [
                'params' => [...$default, self::PARAM_LEVEL => 'A'],
                'expected' => [
                    self::PARAM_LEVEL => [
                        'integer' => 'The provided value must be an integer',
                        'nonNegativeInteger' => 'The provided value must be a non-negative integer',
                    ],
                ],
            ],
            'Boolean page number' => [
                'params' => [...$default, self::PARAM_LEVEL => true],
                'expected' => [
                    self::PARAM_LEVEL => [
                        'integer' => 'The provided value must be an integer',
                    ],
                ],
            ],
            'Alphabetic includeChildren = "A"' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 'A'],
                'expected' => [
                    self::PARAM_INCLUDE_CHILDREN => ['extendedBoolean' => 'The provided value must be a boolean (true, "true", 1, "1", false, "false", 0, "0")',]
                ],
            ],
            'Numeric non-boolean includeChildren = 5' => [
                'params' => [...$default, self::PARAM_INCLUDE_CHILDREN => 5],
                'expected' => [
                    self::PARAM_INCLUDE_CHILDREN => ['extendedBoolean' => 'The provided value must be a boolean (true, "true", 1, "1", false, "false", 0, "0")',]
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

        $objectUnderTest = new IndexQueryParameterInputFilter(
            validator: $validator,
            paginationQueryParameterInputFilter: $this->mockPaginationQueryParameterInputFilter()
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

    public function testFilterCallsPaginationQueryParameterInputFilterFilter(): void
    {
        $paginationQueryParameterInputFilter = $this->mockPaginationQueryParameterInputFilter();
        $params = ['a' => true, 2 => 2];

        $objectUnderTest = new IndexQueryParameterInputFilter(
            validator: $this->mockValidator(),
            paginationQueryParameterInputFilter: $paginationQueryParameterInputFilter
        );

        $paginationQueryParameterInputFilter->expects($this->exactly(1))
            ->method('filter')
            ->with($params);

        $objectUnderTest->filter($params);
    }

    public function testFilterReturnsPaginationQueryParameterInputFilterFilterResult(): void
    {
        $params = ['a' => true, 2 => 2];
        $paginationQueryParameterInputFilter = $this->mockPaginationQueryParameterInputFilter($params);

        $objectUnderTest = new IndexQueryParameterInputFilter(
            validator: $this->mockValidator(),
            paginationQueryParameterInputFilter: $paginationQueryParameterInputFilter
        );

        $this->assertSame(expected: $params, actual: $objectUnderTest->filter([]));
    }

    public function testFilterCallsvalidatorFilterExtendedBoolean(): void
    {
        $validator = $this->mockValidator();
        $params = ['a' => true, 2 => 2, self::PARAM_INCLUDE_CHILDREN => true];

        $objectUnderTest = new IndexQueryParameterInputFilter(
            validator: $validator,
            paginationQueryParameterInputFilter: $this->mockPaginationQueryParameterInputFilter()
        );

        $validator->expects($this->exactly(1))
            ->method('filterExtendedBoolean')
            ->with($params[self::PARAM_INCLUDE_CHILDREN]);

        $objectUnderTest->filter($params);
    }


    public static function dataProviderFilterReturnsValidatorFilterExtendedBooleanResult(): array
    {
        return [
            'false' => [
                'expected' => [self::PARAM_INCLUDE_CHILDREN => false],
            ],
            'true' => [
                'expected' => [self::PARAM_INCLUDE_CHILDREN => true],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderFilterReturnsValidatorFilterExtendedBooleanResult
     */
    public function testFilterReturnsValidatorFilterExtendedBooleanResult(array $expected): void
    {
        $params = [self::PARAM_INCLUDE_CHILDREN => 'Hello there'];

        $objectUnderTest = new IndexQueryParameterInputFilter(
            validator: $this->mockValidator($expected[self::PARAM_INCLUDE_CHILDREN]),
            paginationQueryParameterInputFilter: $this->mockPaginationQueryParameterInputFilter(),
        );

        $this->assertSame(expected: $expected, actual: $objectUnderTest->filter($params));
    }

    public static function dataProviderForFilterReturnsIntegerPage(): array
    {
        return [
            'Integer level number' => [
                'params' => [self::PARAM_LEVEL => 5],
                'expected' => [self::PARAM_LEVEL => 5],
            ],
            'String level number' => [
                'params' => [self::PARAM_LEVEL => '5'],
                'expected' => [self::PARAM_LEVEL => 5],
            ],
            'Not set level' => [
                'params' => [],
                'expected' => [],
            ],
            'Removed unknown params' => [
                'params' => ['a' => true, 2 => 2],
                'expected' => [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForFilterReturnsIntegerPage
     */
    public function testFilterReturnsIntegerPage(array $params, array $expected): void
    {

        $objectUnderTest = new IndexQueryParameterInputFilter(
            validator: $this->mockValidator(),
            paginationQueryParameterInputFilter: $this->mockPaginationQueryParameterInputFilter()
        );

        $this->assertSame(expected: $expected, actual: $objectUnderTest->filter($params));
    }

    /************************
     ***** CREATE MOCKS *****
     ************************/

    public function mockValidator(bool $filterExtendedBooleanResponse = true): CustomValidator|MockObject
    {
        $mock = $this->createMock(CustomValidator::class);
        $mock->method('integer')
            ->willReturnSelf();
        $mock->method('nonNegativeInteger')
            ->willReturnSelf();
        $mock->method('extendedBoolean')
            ->willReturnSelf();
        $mock->method('filterExtendedBoolean')
            ->willReturn($filterExtendedBooleanResponse);

        return $mock;
    }

    public function mockPaginationQueryParameterInputFilter(array $outputParams = []): PaginationQueryParameterInputFilter|MockObject
    {
        $mock = $this->createMock(PaginationQueryParameterInputFilter::class);
        $mock->method('filter')
            ->willReturn($outputParams);

        return $mock;
    }
}
