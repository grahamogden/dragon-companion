import type {
    EntityInterface,
    IndexDestroyEntityInterface,
    IndexEditEntityInterface,
} from "../entity.interface.ts";
import { RolePermissionEntityInterface } from "./role-permission/role-permission.entity.interface.ts";

export interface NewRoleEntityInterface {
    name: string;
    role_permission: RolePermissionEntityInterface;
}

export interface RoleEntityInterface
    extends EntityInterface,
        NewRoleEntityInterface {}

export interface RoleIndexEntityInterface
    extends RoleEntityInterface,
        IndexEditEntityInterface,
        IndexDestroyEntityInterface {}
