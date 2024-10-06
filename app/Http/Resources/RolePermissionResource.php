<?php

namespace App\Http\Resources;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RolePermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            Role::FIELD_ID => $this[Role::FIELD_ID],
            Role::FIELD_NAME => $this[Role::FIELD_NAME],
            Role::FIELD_ROLE_LEVEL => $this[Role::FIELD_ROLE_LEVEL],
            Role::RELATIONSHIP_ROLE_PERMISSION => [
                RolePermission::FIELD_CAMPAIGN_PERMISSIONS => $this->rolePermission[RolePermission::FIELD_CAMPAIGN_PERMISSIONS],
                RolePermission::FIELD_ITEM_PERMISSIONS => $this->rolePermission[RolePermission::FIELD_ITEM_PERMISSIONS],
                RolePermission::FIELD_TIMELINE_PERMISSIONS => $this->rolePermission[RolePermission::FIELD_TIMELINE_PERMISSIONS],
                RolePermission::FIELD_SPECIES_PERMISSIONS => $this->rolePermission[RolePermission::FIELD_SPECIES_PERMISSIONS],
                RolePermission::FIELD_CHARACTER_PERMISSIONS => $this->rolePermission[RolePermission::FIELD_CHARACTER_PERMISSIONS],
                RolePermission::FIELD_MONSTER_PERMISSIONS => $this->rolePermission[RolePermission::FIELD_MONSTER_PERMISSIONS],
            ],
            'destroy_url' => route(
                name: 'creator.campaigns.roles.destroy',
                parameters: [$this->campaign, $this]
            ),
        ];
    }
}
