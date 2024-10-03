<?php

namespace App\Http\Resources\Species;

use App\Http\Resources\EntityOptionResourceTrait;
use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeciesOptionResource extends JsonResource
{
    use EntityOptionResourceTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->transformToOption(
            text: $this[Species::FIELD_NAME],
            value: $this[Species::FIELD_ID],
        );
    }
}
