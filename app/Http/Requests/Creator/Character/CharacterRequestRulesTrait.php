<?php

declare(strict_types=1);

namespace App\Http\Requests\Creator\Character;

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Species;
use App\Rules\SpeciesBelongsToCampaign;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait CharacterRequestRulesTrait
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        return [
            Character::FIELD_NAME => [
                'required',
                'string',
                'max:250',
            ],
            Character::FIELD_AGE => [
                'integer',
                'nullable',
                'between:-2147483648,2147483647',
            ],
            Character::FIELD_MAX_HIT_POINTS => [
                'integer',
                'nullable',
                'between:-32768,32767',
            ],
            Character::FIELD_ARMOUR_CLASS => [
                'integer',
                'nullable',
                'between:-128,127',
            ],
            Character::FIELD_DEXTERITY_MODIFIER => [
                'integer',
                'nullable',
                'between:-128,127',
            ],
            Character::FIELD_APPEARANCE => [
                'string',
                'nullable',
            ],
            Character::FIELD_NOTES => [
                'string',
                'nullable',
            ],
            Character::FIELD_SPECIES_ID => [
                'nullable',
                sprintf('exists:%s,id', Species::TABLE_NAME),
                new SpeciesBelongsToCampaign(campaignId: $request->campaign->id),
            ],
        ];
    }
}
