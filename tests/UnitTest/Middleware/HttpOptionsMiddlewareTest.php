<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Middleware;

use App\Error\Api\BadRequestError;
use App\InputFilter\Api\V1\Timelines\ViewQueryParameterInputFilter;
use App\Middleware\HttpOptionsMiddleware;
use App\Validation\CustomValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HttpOptionsMiddlewareTest extends TestCase
{
    /*********************
     * process tests *
     *********************/

    public function testProcessCallsHandlerHandle(): void
    {
        $request = $this->mockRequest();
        $handler = $this->mockHandler($this->mockResponse());

        $handler->expects($this->exactly(1))
            ->method('handle')
            ->with($request);

        $objectUnderTest = new HttpOptionsMiddleware();

        $objectUnderTest->process(
            request: $request,
            handler: $handler,
        );
    }

    public function testProcessReturnsHandlerHandleResponse(): void
    {
        $response = $this->mockResponse();
        $handler = $this->mockHandler($response);

        $objectUnderTest = new HttpOptionsMiddleware();

        $this->assertSame(
            expected: $response,
            actual: $objectUnderTest->process(
                request: $this->mockRequest(),
                handler: $handler,
            )
        );
    }

    /************************
     ***** CREATE MOCKS *****
     ************************/

    public function mockRequest(): ServerRequestInterface|MockObject
    {
        $mock = $this->createMock(ServerRequestInterface::class);

        return $mock;
    }

    public function mockHandler(ResponseInterface $responseInterface): RequestHandlerInterface|MockObject
    {
        $mock = $this->createMock(RequestHandlerInterface::class);
        $mock->method('handle')
            ->willReturn($responseInterface);

        return $mock;
    }

    public function mockResponse(): ResponseInterface|MockObject
    {
        $mock = $this->createMock(ResponseInterface::class);

        return $mock;
    }
}
