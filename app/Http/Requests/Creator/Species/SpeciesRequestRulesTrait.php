<?php

declare(strict_types=1);

namespace App\Http\Requests\Creator\Species;

use App\Models\Species;
use Illuminate\Contracts\Validation\ValidationRule;

trait SpeciesRequestRulesTrait
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Species::FIELD_NAME => ['required', 'string', 'max:250'],
            Species::FIELD_DESCRIPTION => ['string', 'nullable'],
        ];
    }
}
