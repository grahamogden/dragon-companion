<?php

declare(strict_types=1);

namespace App\Error\Api;

use Cake\Core\Configure;
use Cake\Http\Exception\HttpException;
use Throwable;

class ApiError extends HttpException
{
    protected ?array $errors = [];

    public function __construct(?string $message = null, ?int $code = null, ?Throwable $previous = null, ?array $errors = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function __toString(): string
    {
        $output = ['message' => $this->getMessage()];

        if ($this->errors) {
            $output['errors'] = $this->errors;
        }

        if (Configure::read('debug')) {
            $output += [
                'file' => $this->getFile(),
                'line' => $this->getLine(),
                'trace' => $this->getTrace(),
            ];
        }

        return json_encode($output);
    }
}
