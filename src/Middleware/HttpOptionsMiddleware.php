<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

class HttpOptionsMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        if ($request->getMethod() === 'OPTIONS') {
            // If we have an OPTIONS request come in, we want to return immediately
            header('Content-Length: 0');
            header('Content-Type: text/plain');
            exit();
        }

        return $handler->handle($request);
    }
}
