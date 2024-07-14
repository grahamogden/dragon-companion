<?php

declare(strict_types=1);

namespace App\Validation;

use Cake\Validation\Validator;

class CustomValidator extends Validator
{
    public function extendedBoolean(string $field): self
    {
        return $this->add($field, 'extendedBoolean', [
            'rule' => function ($check, $context) {
                if (
                    $check === true || $check === 'true' || $check === 1 || $check === '1'
                    || $check === false || $check === 'false' || $check === 0 || $check === '0'
                ) {
                    return true;
                }

                return 'The provided value must be a boolean (true, "true", 1, "1", false, "false", 0, "0")';
            }
        ]);
    }

    public function filterExtendedBoolean($input): bool
    {
        return $input === true || $input === 'true' || $input === 1 || $input === '1';
    }
}
