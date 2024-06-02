<?php

declare(strict_types=1);

namespace App\Error\Api;

use App\Error\Api\ApiError;
use Throwable;

class BadRequestError extends ApiError
{
    protected int $_defaultCode = 400;

    public function __construct(string $message = 'Bad Request', ?int $code = null, ?Throwable $previous = null, ?array $errors = [])
    {
        parent::__construct(message: $message, code: $code, previous: $previous, errors: $errors);
    }
}
