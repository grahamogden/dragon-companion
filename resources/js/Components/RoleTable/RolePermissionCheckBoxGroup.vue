<script setup lang="ts">
    import { PermissionBitwiseEnum, PermissionBitwiseUtils, PermissionEnum } from '../../types/entities/role/role-permission';
    import Checkbox from '../Checkbox.vue';

    defineProps({
        permissionName: { type: String, required: true },
        roleId: { type: Number, required: true }
    })

    const permissions = defineModel<PermissionBitwiseEnum>('permissions', {
        required: true, default: PermissionBitwiseEnum.Deny
    })

    const updatePermissions = (isChecked: boolean, value: number) => {
        if (isChecked) {
            permissions.value += value
        } else {
            permissions.value -= value
        }
    }
</script>
<template>
    <div class="">
        <div class="flex grid-cols-2 gap-2 justify-between items-center">
            <Checkbox :checked="PermissionBitwiseUtils.hasPermission(permissions, PermissionEnum.Read)"
                :input-name="permissionName + '-read-checkbox-' + roleId" :error="''"
                @update:checked="updatePermissions" :value="PermissionEnum.Read">Read
            </Checkbox>
        </div>
        <div class="flex grid-cols-2 gap-2 justify-between items-center">
            <Checkbox :checked="PermissionBitwiseUtils.hasPermission(permissions, PermissionEnum.Write)"
                :input-name="permissionName + '-write-checkbox-' + roleId" :error="''"
                @update:checked="updatePermissions" :value="PermissionEnum.Write">Write
            </Checkbox>
        </div>
        <div class="flex grid-cols-2 gap-2 justify-between items-center">
            <Checkbox :checked="PermissionBitwiseUtils.hasPermission(permissions, PermissionEnum.Delete)"
                :input-name="permissionName + '-delete-checkbox-' + roleId" :error="''"
                @update:checked="updatePermissions" :value="PermissionEnum.Delete">Delete
            </Checkbox>
        </div>
    </div>
</template>