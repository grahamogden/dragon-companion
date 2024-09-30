<?php

declare(strict_types=1);

namespace App\Http\Requests\Creator\Timeline;

use App\Models\Timeline;
use Illuminate\Contracts\Validation\ValidationRule;

trait TimelineRequestRulesTrait
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Timeline::FIELD_NAME => ['required', 'string', 'max:250'],
            Timeline::FIELD_DESCRIPTION => ['string', 'nullable'],
            Timeline::FIELD_PARENT_ID => [
                'integer',
                'nullable',
                sprintf('exists:%s,id', Timeline::TABLE_NAME)
            ],
        ];
    }
}
