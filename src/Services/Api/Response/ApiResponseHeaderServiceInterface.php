<?php

declare(strict_types=1);

namespace App\Services\Api\Response;

use Cake\Http\Response;

interface ApiResponseHeaderServiceInterface
{
    public function returnOkResponse(Response $response): Response;
    public function returnNotFoundResponse(Response $response): Response;
    public function returnBadRequestResponse(Response $response): Response;
    public function returnCreatedResponse(Response $response): Response;
    public function returnNoContentResponse(Response $response): Response;
    public function returnUnauthorizedResponse(Response $response): Response;
    public function returnUnknownServerErrorResponse(Response $response): Response;
}
