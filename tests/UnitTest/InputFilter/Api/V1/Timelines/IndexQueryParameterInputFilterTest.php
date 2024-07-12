<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Policy;

use App\Error\Api\BadRequestError;
use App\InputFilter\Api\V1\PaginationQueryParameterInputFilter;
use App\InputFilter\Api\V1\Timelines\IndexQueryParameterInputFilter;
use Cake\Validation\Validator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\exactly;

class IndexQueryParameterInputFilterTest extends TestCase
{
    public const PARAM_LEVEL = 'level';


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
        ];

        return [
            'Default' => [
                'params' => $default,
            ],
            'Large level' => [
                'params' => [...$default, self::PARAM_LEVEL => 20000000],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForValidateValidParams
     */
    public function testValidateValidParams(array $params): void
    {
        $validator = new Validator();

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
        ];
    }

    /**
     * @dataProvider dataProviderForValidateThrowsBadRequestIfInvalidParams
     */
    public function testValidateThrowsBadRequestIfInvalidParams(array $params, array $expected): void
    {
        $validator = new Validator();

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

    public function testFilterDoesNotReturnUnknownParams(): void
    {

        $objectUnderTest = new IndexQueryParameterInputFilter(
            validator: $this->mockValidator(),
            paginationQueryParameterInputFilter: $this->mockPaginationQueryParameterInputFilter()
        );

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

    public function mockPaginationQueryParameterInputFilter(array $outputParams = []): PaginationQueryParameterInputFilter|MockObject
    {
        $mock = $this->createMock(PaginationQueryParameterInputFilter::class);
        $mock->method('filter')
            ->willReturn($outputParams);

        return $mock;
    }
}
