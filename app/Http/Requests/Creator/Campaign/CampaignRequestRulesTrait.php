<?php

declare(strict_types=1);

namespace App\Http\Requests\Creator\Campaign;

use App\Models\Campaign;
use Illuminate\Contracts\Validation\ValidationRule;

trait CampaignRequestRulesTrait
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Campaign::FIELD_NAME => ['required', 'string', 'max:250'],
            Campaign::FIELD_SYNOPSIS => ['string', 'nullable'],
        ];
    }
}
