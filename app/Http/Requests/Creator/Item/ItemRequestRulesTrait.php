<?php

declare(strict_types=1);

namespace App\Http\Requests\Creator\Item;

use App\Models\Item;
use Illuminate\Contracts\Validation\ValidationRule;

trait ItemRequestRulesTrait
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Item::FIELD_NAME => ['required', 'string', 'max:250'],
            Item::FIELD_DESCRIPTION => ['string', 'nullable'],
        ];
    }
}
