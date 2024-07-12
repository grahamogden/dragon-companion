<?php

declare(strict_types=1);

namespace App\InputFilter\Api\V1\Timelines;

use App\Error\Api\BadRequestError;
use Cake\Validation\Validator;
use App\InputFilter\Api\V1\QueryParameterInputFilterInterface;

class IndexQueryParameterInputFilter implements QueryParameterInputFilterInterface
{
    public const PARAM_PAGE = 'page';
    public const PARAM_LIMIT = 'limit';
    public const PARAM_LEVEL = 'level';

    public function __construct(
        private readonly Validator $validator,
    ) {
        $this->initialiseValidator();
    }

    protected function initialiseValidator(): void
    {
        $this->validator
            ->integer(self::PARAM_PAGE)
            ->nonNegativeInteger(self::PARAM_PAGE);

        $this->validator
            ->integer(self::PARAM_LIMIT)
            ->nonNegativeInteger(self::PARAM_LIMIT);

        $this->validator
            ->integer(self::PARAM_LEVEL)
            ->nonNegativeInteger(self::PARAM_LEVEL);
    }

    public function validate(array $params): void
    {
        $errors = $this->validator->validate($params);

        if (!empty($errors)) {
            throw new BadRequestError(errors: $errors);
        }
    }

    public function filter(array $params): array
    {
        if (isset($params[self::PARAM_PAGE])) {
            $params[self::PARAM_PAGE] = (int) $params[self::PARAM_PAGE];
        }

        if (isset($params[self::PARAM_LIMIT])) {
            $params[self::PARAM_LIMIT] = (int) $params[self::PARAM_LIMIT];
        }

        if (isset($params[self::PARAM_LEVEL])) {
            $params[self::PARAM_LEVEL] = (int) $params[self::PARAM_LEVEL];
        }

        return $params;
    }
}
