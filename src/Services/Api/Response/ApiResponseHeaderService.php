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
        $response = $response->withStatus(201);
        return $response;
    }

    public function returnNoContentResponse(Response $response): Response
    {
        $response = $response->withStatus(204);
        return $response;
    }

    public function returnBadRequestResponse(Response $response): Response
    {
        $response = $response->withStatus(400);
        return $response;
    }

    public function returnUnauthorizedResponse(Response $response): Response
    {
        $response = $response->withStatus(401);
        return $response;
    }

    public function returnNotFoundResponse(Response $response): Response
    {
        $response = $response->withStatus(404);
        return $response;
    }
}
