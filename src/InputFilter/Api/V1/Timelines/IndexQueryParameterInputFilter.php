<?php

declare(strict_types=1);

namespace App\InputFilter\Api\V1\Timelines;

use App\Error\Api\BadRequestError;
use App\InputFilter\Api\V1\PaginationQueryParameterInputFilter;
use Cake\Validation\Validator;
use App\InputFilter\Api\V1\QueryParameterInputFilterInterface;

class IndexQueryParameterInputFilter implements QueryParameterInputFilterInterface
{
    public const PARAM_LEVEL = 'level';

    public function __construct(
        private readonly Validator $validator,
        private readonly PaginationQueryParameterInputFilter $paginationQueryParameterInputFilter
    ) {
        $this->initialiseValidator();
    }

    private function initialiseValidator(): void
    {
        $this->validator
            ->integer(self::PARAM_LEVEL)
            ->nonNegativeInteger(self::PARAM_LEVEL);
    }

    public function validate(array $params): void
    {
        $this->paginationQueryParameterInputFilter->validate($params);

        $errors = $this->validator->validate($params);

        if (!empty($errors)) {
            throw new BadRequestError(errors: $errors);
        }
    }

    public function filter(array $input): array
    {
        $output = $this->paginationQueryParameterInputFilter->filter($input);

        if (isset($input[self::PARAM_LEVEL])) {
            $output[self::PARAM_LEVEL] = (int) $input[self::PARAM_LEVEL];
        }

        return $output;
    }
}
