export enum PermissionEnum {
    Deny = 0,
    Read = 1,
    Write = 2,
    Delete = 4,
}

export enum PermissionBitwiseEnum {
    Deny = 0,
    Read = 1,
    Write = 2,
    Delete = 4,
    Read_or_write = 3,
    Read_or_delete = 5,
    Write_or_delete = 6,
    Read_or_write_or_delete = 7,
}

export class PermissionBitwiseUtils {
    static hasPermission(value: number, permission: PermissionEnum) {
        return (value & permission) === permission;
    }

    static calculatePermissionValue(
        permissions: number[]
    ): PermissionBitwiseEnum {
        return permissions.reduce(
            (accumulator, currentValue) => accumulator + currentValue,
            0
        );
    }
}
