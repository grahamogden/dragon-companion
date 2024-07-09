<?php

declare(strict_types=1);

namespace App\Error\Api;

use App\Error\Api\ApiError;
use Throwable;

class ForbiddenError extends ApiError
{
    protected int $_defaultCode = 403;

    public function __construct(string $message = 'Forbidden', ?int $code = null, ?Throwable $previous = null, ?array $errors = [])
    {
        parent::__construct(message: $message, code: $code, previous: $previous, errors: $errors);
    }
}
