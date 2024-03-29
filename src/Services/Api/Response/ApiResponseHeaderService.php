<?php

declare(strict_types=1);

namespace App\Services\Api\Response;

use Cake\Http\Response;

final class ApiResponseHeaderService implements ApiResponseHeaderServiceInterface
{
    public function returnOkResponse(Response $response): void
    {
        $response = $response->withStatus(200);
    }

    public function returnNotFoundResponse(Response $response): void
    {
        $response = $response->withStatus(404);
    }

    public function returnBadRequestResponse(Response $response): void
    {
        $response = $response->withStatus(400);
    }

    public function returnCreatedResponse(Response $response): void
    {
        $response = $response->withStatus(201);
    }

    public function returnNoContentResponse(Response $response): void
    {
        $response = $response->withStatus(204);
    }

    public function returnUnauthorizedResponse(Response $response): void
    {
        $response = $response->withStatus(401);
    }
}
