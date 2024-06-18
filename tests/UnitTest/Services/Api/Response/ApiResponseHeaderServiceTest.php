<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Services\Api\Response;

use App\Services\Api\Response\ApiResponseHeaderService;
use Cake\Http\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ApiResponseHeaderServiceTest extends TestCase
{
    /**************************
     * returnOkResponse tests *
     **************************/

    public function testReturnOkResponseCallsResponseWithStatus(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $response->expects(self::exactly(1))
            ->method('withStatus')
            ->with(200);

        $objectUnderTest->returnOkResponse($response);
    }

    public function testReturnOkResponseReturnsResponse(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $this->assertSame(
            $response,
            $objectUnderTest->returnOkResponse($response)
        );
    }

    /*******************************
     * returnCreatedResponse tests *
     *******************************/

    public function testReturnCreatedResponseCallsResponseWithStatus(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $response->expects(self::exactly(1))
            ->method('withStatus')
            ->with(201);

        $objectUnderTest->returnCreatedResponse($response);
    }

    public function testReturnCreatedResponseReturnsResponse(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $this->assertSame(
            $response,
            $objectUnderTest->returnCreatedResponse($response)
        );
    }

    /*********************************
     * returnNoContentResponse tests *
     *********************************/

    public function testReturnNoContentResponseCallsResponseWithStatus(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $response->expects(self::exactly(1))
            ->method('withStatus')
            ->with(204);

        $objectUnderTest->returnNoContentResponse($response);
    }

    public function testReturnNoContentResponseReturnsResponse(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $this->assertSame(
            $response,
            $objectUnderTest->returnNoContentResponse($response)
        );
    }

    /**********************************
     * returnBadRequestResponse tests *
     **********************************/

    public function testReturnBadRequestResponseCallsResponseWithStatus(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $response->expects(self::exactly(1))
            ->method('withStatus')
            ->with(400);

        $objectUnderTest->returnBadRequestResponse($response);
    }

    public function testReturnBadRequestResponseReturnsResponse(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $this->assertSame(
            $response,
            $objectUnderTest->returnBadRequestResponse($response)
        );
    }

    /************************************
     * returnUnauthorizedResponse tests *
     ************************************/

    public function testReturnUnauthorizedResponseCallsResponseWithStatus(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $response->expects(self::exactly(1))
            ->method('withStatus')
            ->with(401);

        $objectUnderTest->returnUnauthorizedResponse($response);
    }

    public function testReturnUnauthorizedResponseReturnsResponse(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $this->assertSame(
            $response,
            $objectUnderTest->returnUnauthorizedResponse($response)
        );
    }

    /********************************
     * returnNotFoundResponse tests *
     ********************************/

    public function testReturnNotFoundResponseCallsResponseWithStatus(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $response->expects(self::exactly(1))
            ->method('withStatus')
            ->with(404);

        $objectUnderTest->returnNotFoundResponse($response);
    }

    public function testReturnNotFoundResponseReturnsResponse(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $this->assertSame(
            $response,
            $objectUnderTest->returnNotFoundResponse($response)
        );
    }

    /******************************************
     * returnUnknownServerErrorResponse tests *
     ******************************************/

    public function testReturnUnknownServerErrorResponseCallsResponseWithStatus(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $response->expects(self::exactly(1))
            ->method('withStatus')
            ->with(500);

        $objectUnderTest->returnUnknownServerErrorResponse($response);
    }

    public function testReturnUnknownServerErrorResponseReturnsResponse(): void
    {
        $objectUnderTest = new ApiResponseHeaderService();

        $response = $this->mockResponse();

        $this->assertSame(
            $response,
            $objectUnderTest->returnUnknownServerErrorResponse($response)
        );
    }

    /************************
     ***** CREATE MOCKS *****
     ************************/

    public function mockResponse(): Response|MockObject
    {
        $mock = $this->createMock(Response::class);
        $mock->method('withStatus')
            ->willReturnSelf();

        return $mock;
    }
}
