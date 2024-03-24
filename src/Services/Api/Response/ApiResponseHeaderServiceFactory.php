<?php

declare(strict_types=1);

namespace App\Services\Api\Response;

final class ApiResponseHeaderServiceFactory
{
    public function __invoke(): ApiResponseHeaderService
    {
        return new ApiResponseHeaderService();
    }
}
