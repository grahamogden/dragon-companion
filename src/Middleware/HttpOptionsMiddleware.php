<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HttpOptionsMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {

        /** @infection-ignore-all */
        if ($request->getMethod() === 'OPTIONS') {
            // @codeCoverageIgnoreStart
            // If we have an OPTIONS request come in, we want to return immediately
            header('Content-Length: 0');
            header('Content-Type: text/plain');
            exit();
            // @codeCoverageIgnoreEnd
        }

        return $handler->handle($request);
    }
}
