import { RolePermissionEntityInterface } from "./role-permission";
import { RoleEntityInterface } from "./role.entity.interface";

export class RoleEntity implements RoleEntityInterface {
    id?: number;
    name: string;
    role_permission: RolePermissionEntityInterface;

    constructor(
        name: string,
        permissions: RolePermissionEntityInterface,
        id?: number
    ) {
        this.id = id;
        this.name = name;
        this.role_permission = permissions;
    }
}
