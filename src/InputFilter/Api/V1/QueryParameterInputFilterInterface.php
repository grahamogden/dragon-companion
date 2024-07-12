<?php

declare(strict_types=1);

namespace App\InputFilter\Api\V1;

interface QueryParameterInputFilterInterface
{
    public function validate(array $params): void;

    public function filter(array $params): array;
}
