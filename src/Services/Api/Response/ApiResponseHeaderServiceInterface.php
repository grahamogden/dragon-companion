<?php

declare(strict_types=1);

namespace App\Services\Api\Response;

use Cake\Http\Response;

interface ApiResponseHeaderServiceInterface
{
    public function returnOkResponse(Response $response): void;
    public function returnNotFoundResponse(Response $response): void;
    public function returnBadRequestResponse(Response $response): void;
    public function returnCreatedResponse(Response $response): void;
    public function returnNoContentResponse(Response $response): void;
    public function returnUnauthorizedResponse(Response $response): void;
}
