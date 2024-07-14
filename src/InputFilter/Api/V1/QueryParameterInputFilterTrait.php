<?php

declare(strict_types=1);

namespace App\InputFilter\Api\V1;

trait QueryParameterInputFilterTrait
{
    public function validateAndFilter(array $params): array
    {
        $this->validate(params: $params);

        return $this->filter(input: $params);
    }
}
