<?php

declare(strict_types=1);

namespace App\Services\Api\Response;

use Cake\Http\Response;

final class ApiResponseHeaderService implements ApiResponseHeaderServiceInterface
{
    public function returnOkResponse(Response $response): Response
    {
        $response = $response->withStatus(200);
        return $response;
    }

    public function returnCreatedResponse(Response $response): Response
    {
        return $response->withStatus(201);
    }

    public function returnNoContentResponse(Response $response): Response
    {
        return $response->withStatus(204);
    }

    public function returnBadRequestResponse(Response $response): Response
    {
        return $response->withStatus(400);
    }

    public function returnUnauthorizedResponse(Response $response): Response
    {
        return $response->withStatus(401);
    }

    public function returnNotFoundResponse(Response $response): Response
    {
        return $response->withStatus(404);
    }

    public function returnLockedResponse(Response $response): Response
    {
        return $response->withStatus(423);
    }

    public function returnUnknownServerErrorResponse(Response $response): Response
    {
        return $response->withStatus(500);
    }
}
