import type {
    EntityInterface,
    IndexDestroyEntityInterface,
} from "../../entity.interface.ts";
import { RoleLevelEnum } from "../role-level.enum.ts";
import { PermissionBitwiseEnum } from "./permission.enum.ts";

export interface NewRolePermissionEntityInterface {
    name: string;
    role_level: RoleLevelEnum;
    rolePermission: {
        campaign_permissions: PermissionBitwiseEnum;
        item_permissions: PermissionBitwiseEnum;
        timeline_permissions: PermissionBitwiseEnum;
        species_permissions: PermissionBitwiseEnum;
        character_permissions: PermissionBitwiseEnum;
        monster_permissions: PermissionBitwiseEnum;
    };
}

export interface RolePermissionEntityInterface
    extends EntityInterface,
        NewRolePermissionEntityInterface,
        IndexDestroyEntityInterface {}
