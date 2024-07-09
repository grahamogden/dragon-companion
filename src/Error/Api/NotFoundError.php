<?php

declare(strict_types=1);

namespace App\Error\Api;

use App\Error\Api\ApiError;
use Throwable;

class NotFoundError extends ApiError
{
    protected int $_defaultCode = 404;

    public function __construct(string $message = 'Not Found', ?int $code = null, ?Throwable $previous = null, ?array $errors = [])
    {
        parent::__construct(message: $message, code: $code, previous: $previous, errors: $errors);
    }
}
