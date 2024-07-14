<?php

declare(strict_types=1);

namespace App\InputFilter\Api\V1\Timelines;

use App\Error\Api\BadRequestError;
use App\InputFilter\Api\V1\PaginationQueryParameterInputFilter;
use App\InputFilter\Api\V1\QueryParameterInputFilterInterface;
use App\InputFilter\Api\V1\QueryParameterInputFilterTrait;
use App\Validation\CustomValidator;

class IndexQueryParameterInputFilter implements QueryParameterInputFilterInterface
{
    use QueryParameterInputFilterTrait;

    public const PARAM_LEVEL = 'level';

    public const PARAM_INCLUDE_CHILDREN = 'includeChildren';

    public function __construct(
        private readonly CustomValidator $validator,
        private readonly PaginationQueryParameterInputFilter $paginationQueryParameterInputFilter
    ) {
        $this->initialiseValidator();
    }

    private function initialiseValidator(): void
    {
        $this->validator
            ->integer(self::PARAM_LEVEL)
            ->nonNegativeInteger(self::PARAM_LEVEL);

        $this->validator
            ->extendedBoolean(self::PARAM_INCLUDE_CHILDREN);
    }

    public function validate(array $params): void
    {
        $this->paginationQueryParameterInputFilter->validate($params);

        $errors = $this->validator->validate($params);

        if (!empty($errors)) {
            throw new BadRequestError(errors: $errors);
        }
    }

    public function filter(array $params): array
    {
        $output = $this->paginationQueryParameterInputFilter->filter($params);

        if (isset($params[self::PARAM_LEVEL])) {
            $output[self::PARAM_LEVEL] = (int) $params[self::PARAM_LEVEL];
        }

        if (isset($params[self::PARAM_INCLUDE_CHILDREN])) {
            $output[self::PARAM_INCLUDE_CHILDREN] = $this->validator->filterExtendedBoolean($params[self::PARAM_INCLUDE_CHILDREN]);
        }

        return $output;
    }
}
