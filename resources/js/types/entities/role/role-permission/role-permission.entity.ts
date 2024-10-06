import { PermissionEnum } from "./permission.enum.ts";
import { type RolePermissionEntityInterface } from "./role-permission.entity.interface.ts";

export class RolePermissionEntity implements RolePermissionEntityInterface {
    id: number;
    name: string;
    campaign_permissions: PermissionEnum;
    item_permissions: PermissionEnum;
    timeline_permissions: PermissionEnum;
    species_permissions: PermissionEnum;
    character_permissions: PermissionEnum;
    monster_permissions: PermissionEnum;

    constructor(
        id: number,
        name: string,
        campaign_permissions: PermissionEnum,
        item_permissions: PermissionEnum,
        timeline_permissions: PermissionEnum,
        species_permissions: PermissionEnum,
        character_permissions: PermissionEnum,
        monster_permissions: PermissionEnum
    ) {
        this.id = id;
        this.name = name;
        this.campaign_permissions = campaign_permissions;
        this.item_permissions = item_permissions;
        this.timeline_permissions = timeline_permissions;
        this.species_permissions = species_permissions;
        this.character_permissions = character_permissions;
        this.monster_permissions = monster_permissions;
    }
}
