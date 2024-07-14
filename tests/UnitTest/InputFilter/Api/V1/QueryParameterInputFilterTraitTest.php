<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Policy;

use App\InputFilter\Api\V1\PaginationQueryParameterInputFilter;
use App\InputFilter\Api\V1\QueryParameterInputFilterInterface;
use App\InputFilter\Api\V1\QueryParameterInputFilterTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Throwable;

class QueryParameterInputFilterTraitTest extends TestCase
{
    public const PARAM_PAGE = 'page';
    public const PARAM_LIMIT = 'limit';


    /*********************
     * constructor tests *
     *********************/

    public function testValidateAndFilterCallsValidate(): void
    {
        $mockObject = $this->mockObject();
        $params = ['a' => true, 2 => 2];

        $mockObject->expects($this->exactly(1))
            ->method('validate')
            ->with($params);

        $objectUnderTest = new DummyQueryParameterInputFilterTrait(
            mockObject: $mockObject
        );

        $objectUnderTest->validateAndFilter(params: $params);
    }

    public function testValidateAndFilterCallsFilter(): void
    {
        $mockObject = $this->mockObject();
        $params = ['a' => true, 2 => 2];

        $mockObject->expects($this->exactly(1))
            ->method('validate')
            ->with($params);

        $objectUnderTest = new DummyQueryParameterInputFilterTrait(
            mockObject: $mockObject
        );

        $objectUnderTest->validateAndFilter(params: $params);
    }

    public function testValidateAndFilterReturnsFilterResponse(): void
    {
        $params = ['a' => true, 2 => 2];

        $objectUnderTest = new DummyQueryParameterInputFilterTrait(
            mockObject: $this->mockObject($params)
        );

        $this->assertSame(
            expected: $params,
            actual: $objectUnderTest->validateAndFilter(params: [])
        );
    }

    /************************
     ***** CREATE MOCKS *****
     ************************/

    private function mockObject(array $filterResponse = []): QueryParameterInputFilterInterface&MockObject
    {
        $mock = $this->createMock(QueryParameterInputFilterInterface::class);
        $mock->method('filter')
            ->willReturn($filterResponse);

        return $mock;
    }
}

class DummyQueryParameterInputFilterTrait implements QueryParameterInputFilterInterface
{
    use QueryParameterInputFilterTrait;

    public function __construct(
        private readonly MockObject&QueryParameterInputFilterInterface $mockObject
    ) {
    }

    public function validate(array $params): void
    {
        $this->mockObject->validate($params);
    }

    public function filter(array $params): array
    {
        return $this->mockObject->filter(params: $params);
    }
}
