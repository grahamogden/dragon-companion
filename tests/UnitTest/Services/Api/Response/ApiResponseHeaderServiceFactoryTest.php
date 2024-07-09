<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Services\Api\Response;

use App\Services\Api\Response\ApiResponseHeaderService;
use App\Services\Api\Response\ApiResponseHeaderServiceFactory;
use Cake\Http\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ApiResponseHeaderServiceFactoryTest extends TestCase
{
    /**************************
     * returnOkResponse tests *
     **************************/

    public function testReturnsApiResponseHeaderService(): void
    {
        $objectUnderTest = new ApiResponseHeaderServiceFactory();

        $this->assertInstanceOf(
            ApiResponseHeaderService::class,
            $objectUnderTest()
        );
    }
}
