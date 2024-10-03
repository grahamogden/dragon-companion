<?php

namespace App\Http\Resources;

use App\Models\Monster;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonsterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            Monster::FIELD_NAME => $this[Monster::FIELD_NAME],
            Monster::FIELD_DESCRIPTION => $this[Monster::FIELD_DESCRIPTION],
            Monster::FIELD_SIZE => $this[Monster::FIELD_SIZE],
            Monster::FIELD_DEFAULT_HIT_POINTS => $this[Monster::FIELD_DEFAULT_HIT_POINTS],
            Monster::FIELD_CALCULATED_HIT_POINTS_DICE_COUNT => $this[Monster::FIELD_CALCULATED_HIT_POINTS_DICE_COUNT],
            Monster::FIELD_CALCULATED_HIT_POINTS_DICE_TYPE => $this[Monster::FIELD_CALCULATED_HIT_POINTS_DICE_TYPE],
            Monster::FIELD_CALCULATED_HIT_POINTS_MODIFIER => $this[Monster::FIELD_CALCULATED_HIT_POINTS_MODIFIER],
            Monster::FIELD_ARMOUR_CLASS => $this[Monster::FIELD_ARMOUR_CLASS],
            Monster::FIELD_SPEED => $this[Monster::FIELD_SPEED],
            Monster::FIELD_CHALLENGE_RATING => $this[Monster::FIELD_CHALLENGE_RATING],
            Monster::FIELD_CAMPAIGN_ID => $this[Monster::FIELD_CAMPAIGN_ID],
            Monster::FIELD_USER_ID => $this[Monster::FIELD_USER_ID],
            Monster::FIELD_SPECIES_ID => $this[Monster::FIELD_SPECIES_ID],
            'show_url' => route(
                name: 'creator.campaigns.monsters.show',
                parameters: [$this->campaign, $this]
            ),
            'edit_url' => route(
                name: 'creator.campaigns.monsters.edit',
                parameters: [$this->campaign, $this]
            ),
            'destroy_url' => route(
                name: 'creator.campaigns.monsters.destroy',
                parameters: [$this->campaign, $this]
            ),
        ];
    }
}
