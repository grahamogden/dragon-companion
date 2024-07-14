<?php

declare(strict_types=1);

namespace App\InputFilter\Api\V1\Timelines;

use App\Error\Api\BadRequestError;
use App\Validation\CustomValidator;
// use Cake\Validation\Validator;
use App\InputFilter\Api\V1\QueryParameterInputFilterInterface;
use App\InputFilter\Api\V1\QueryParameterInputFilterTrait;

class ViewQueryParameterInputFilter implements QueryParameterInputFilterInterface
{
    use QueryParameterInputFilterTrait;

    public const PARAM_INCLUDE_CHILDREN = 'includeChildren';

    public function __construct(private readonly CustomValidator $validator)
    {
        $this->initialiseValidator();
    }

    private function initialiseValidator(): void
    {
        $this->validator
            ->extendedBoolean(self::PARAM_INCLUDE_CHILDREN);
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

        if (isset($input[self::PARAM_INCLUDE_CHILDREN])) {
            $output[self::PARAM_INCLUDE_CHILDREN] = $this->validator->filterExtendedBoolean($input[self::PARAM_INCLUDE_CHILDREN]);
        }

        return $output;
    }
}
