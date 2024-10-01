<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            Item::FIELD_ID => $this[Item::FIELD_ID],
            Item::FIELD_NAME => $this[Item::FIELD_NAME],
            Item::FIELD_DESCRIPTION => $this[Item::FIELD_DESCRIPTION],
            Item::FIELD_CAMPAIGN_ID => $this[Item::FIELD_CAMPAIGN_ID],
            Item::FIELD_USER_ID => $this[Item::FIELD_USER_ID],
            'show_url' => route(
                name: 'creator.campaigns.items.show',
                parameters: [$this->campaign, $this]
            ),
            'edit_url' => route(
                name: 'creator.campaigns.items.edit',
                parameters: [$this->campaign, $this]
            ),
            'destroy_url' => route(
                name: 'creator.campaigns.items.destroy',
                parameters: [$this->campaign, $this]
            ),
        ];
    }
}
