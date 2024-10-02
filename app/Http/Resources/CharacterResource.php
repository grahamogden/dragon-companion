<?php

namespace App\Http\Resources;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            Character::FIELD_ID => $this[Character::FIELD_ID],
            Character::FIELD_NAME => $this[Character::FIELD_NAME],
            Character::FIELD_AGE => $this[Character::FIELD_AGE],
            Character::FIELD_MAX_HIT_POINTS => $this[Character::FIELD_MAX_HIT_POINTS],
            Character::FIELD_ARMOUR_CLASS => $this[Character::FIELD_ARMOUR_CLASS],
            Character::FIELD_DEXTERITY_MODIFIER => $this[Character::FIELD_DEXTERITY_MODIFIER],
            Character::FIELD_APPEARANCE => $this[Character::FIELD_APPEARANCE],
            Character::FIELD_NOTES => $this[Character::FIELD_NOTES],
            Character::FIELD_SPECIES_ID => $this[Character::FIELD_SPECIES_ID],
            Character::FIELD_CAMPAIGN_ID => $this[Character::FIELD_CAMPAIGN_ID],
            Character::FIELD_USER_ID => $this[Character::FIELD_USER_ID],
            'show_url' => route(
                name: 'creator.campaigns.characters.show',
                parameters: [$this->campaign, $this]
            ),
            'edit_url' => route(
                name: 'creator.campaigns.characters.edit',
                parameters: [$this->campaign, $this]
            ),
            'destroy_url' => route(
                name: 'creator.campaigns.characters.destroy',
                parameters: [$this->campaign, $this]
            ),
        ];
    }
}
