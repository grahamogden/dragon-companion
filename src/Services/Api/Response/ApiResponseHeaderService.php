<?php

declare(strict_types=1);

namespace App\Services\Api\Response;

use Cake\Http\Response;

final class ApiResponseHeaderService implements ApiResponseHeaderServiceInterface
{
    public function returnOkResponse(Response $response): void
    {
        $response->withStatus(200); //, 'Ok');
        // header('HTTP/1.0 200 Ok');
        // exit;
    }

    public function returnNotFoundResponse(Response $response): void
    {
        $response->withStatus(404); //, 'Not found');
        // header('HTTP/1.0 404 Not found');
        // exit;
    }

    public function returnBadRequestResponse(Response $response): void
    {
        $response->withStatus(400); //, 'Bad request');
        // header('HTTP/1.0 400 Bad request');
        // exit;
    }

    public function returnCreatedResponse(Response $response): void
    {
        $response->withStatus(201); //, 'Created');
        // header('HTTP/1.0 201 Created');
        // exit;
    }

    public function returnNoContentResponse(Response $response): void
    {
        $response->withStatus(204); //, 'No content');
        // header('HTTP/1.0 204 No content');
        // exit;
    }

    public function returnUnauthorizedResponse(Response $response): void
    {
        $response->withStatus(401); //, 'Unauthorized');
        // header('HTTP/1.0 401 Unauthorized');
        // exit;
    }
}
