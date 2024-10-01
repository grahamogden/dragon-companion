<?php

namespace App\Http\Resources;

use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeciesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            Species::FIELD_ID => $this[Species::FIELD_ID],
            Species::FIELD_NAME => $this[Species::FIELD_NAME],
            Species::FIELD_DESCRIPTION => $this[Species::FIELD_DESCRIPTION],
            Species::FIELD_CAMPAIGN_ID => $this[Species::FIELD_CAMPAIGN_ID],
            Species::FIELD_USER_ID => $this[Species::FIELD_USER_ID],
            'show_url' => route(
                name: 'creator.campaigns.species.show',
                parameters: [$this->campaign, $this]
            ),
            'edit_url' => route(
                name: 'creator.campaigns.species.edit',
                parameters: [$this->campaign, $this]
            ),
            'destroy_url' => route(
                name: 'creator.campaigns.species.destroy',
                parameters: [$this->campaign, $this]
            ),
        ];
    }
}
