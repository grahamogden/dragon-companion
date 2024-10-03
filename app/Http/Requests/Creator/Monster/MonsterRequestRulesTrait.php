<?php

declare(strict_types=1);

namespace App\Http\Requests\Creator\Monster;

use App\Enums\MonsterChallengeRating;
use App\Enums\MonsterSize;
use App\Models\Campaign;
use App\Models\Monster;
use App\Models\Species;
use App\Rules\SpeciesBelongsToCampaign;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait MonsterRequestRulesTrait
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        return [
            Monster::FIELD_NAME => [
                'required',
                'string',
                'max:250',
            ],
            Monster::FIELD_DESCRIPTION => [
                'string',
                'nullable',
            ],
            Monster::FIELD_SIZE => [
                Rule::enum(type: MonsterSize::class)
            ],
            Monster::FIELD_DEFAULT_HIT_POINTS => [
                'integer',
                'nullable',
                'between:-2147483648,2147483647',
            ],
            Monster::FIELD_CALCULATED_HIT_POINTS_DICE_COUNT => [
                'integer',
                'nullable',
                'between:-128,127',
            ],
            Monster::FIELD_CALCULATED_HIT_POINTS_DICE_TYPE => [
                'integer',
                'nullable',
                'between:-128,127',
            ],
            Monster::FIELD_CALCULATED_HIT_POINTS_MODIFIER => [
                'integer',
                'nullable',
                'between:-128,127',
            ],
            Monster::FIELD_ARMOUR_CLASS => [
                'integer',
                'nullable',
                'between:-128,127',
            ],
            Monster::FIELD_SPEED => [
                'integer',
                'nullable',
                'between:-128,127',
            ],
            Monster::FIELD_CHALLENGE_RATING => [
                Rule::enum(type: MonsterChallengeRating::class)
            ],
            Monster::FIELD_SPECIES_ID => [
                'nullable',
                sprintf('exists:%s,id', Species::TABLE_NAME),
                new SpeciesBelongsToCampaign(campaignId: $request->campaign->id),
            ],
        ];
    }
}
