<?php

declare(strict_types=1);

namespace App\Http\Requests\Creator\Role;

use App\Enums\RolePermissionEnum;
use App\Enums\RoleLevelEnum;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait RoleRequestRulesTrait
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Role::FIELD_NAME => ['required', 'string', 'max:250'],
            Role::FIELD_ROLE_LEVEL => ['required', Rule::enum(type: RoleLevelEnum::class)],
            Role::RELATIONSHIP_ROLE_PERMISSION . '.' . RolePermission::FIELD_CAMPAIGN_PERMISSIONS => Rule::enum(type: RolePermissionEnum::class),
            Role::RELATIONSHIP_ROLE_PERMISSION . '.' . RolePermission::FIELD_ITEM_PERMISSIONS => Rule::enum(type: RolePermissionEnum::class),
            Role::RELATIONSHIP_ROLE_PERMISSION . '.' . RolePermission::FIELD_TIMELINE_PERMISSIONS => Rule::enum(type: RolePermissionEnum::class),
            Role::RELATIONSHIP_ROLE_PERMISSION . '.' . RolePermission::FIELD_SPECIES_PERMISSIONS => Rule::enum(type: RolePermissionEnum::class),
            Role::RELATIONSHIP_ROLE_PERMISSION . '.' . RolePermission::FIELD_CHARACTER_PERMISSIONS => Rule::enum(type: RolePermissionEnum::class),
            Role::RELATIONSHIP_ROLE_PERMISSION . '.' . RolePermission::FIELD_MONSTER_PERMISSIONS => Rule::enum(type: RolePermissionEnum::class),
        ];
    }
}
