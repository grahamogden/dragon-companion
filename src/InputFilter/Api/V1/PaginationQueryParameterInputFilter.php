<?php

declare(strict_types=1);

namespace App\InputFilter\Api\V1;

use App\Error\Api\BadRequestError;
use Cake\Validation\Validator;
use App\InputFilter\Api\V1\QueryParameterInputFilterInterface;

class PaginationQueryParameterInputFilter implements QueryParameterInputFilterInterface
{
    public const PARAM_PAGE = 'page';
    public const PARAM_LIMIT = 'limit';

    public function __construct(
        private readonly Validator $validator,
    ) {
        $this->initialiseValidator();
    }

    private function initialiseValidator(): void
    {
        $this->validator
            ->integer(self::PARAM_PAGE)
            ->nonNegativeInteger(self::PARAM_PAGE);

        $this->validator
            ->integer(self::PARAM_LIMIT)
            ->nonNegativeInteger(self::PARAM_LIMIT);
    }

    public function validate(array $params): void
    {
        $errors = $this->validator->validate($params);

        if (!empty($errors)) {
            throw new BadRequestError(errors: $errors);
        }
    }

    public function filter(array $input): array
    {
        $output = [];

        if (isset($input[self::PARAM_PAGE])) {
            $output[self::PARAM_PAGE] = (int) $input[self::PARAM_PAGE];
        }

        if (isset($input[self::PARAM_LIMIT])) {
            $output[self::PARAM_LIMIT] = (int) $input[self::PARAM_LIMIT];
        }

        return $output;
    }
}
