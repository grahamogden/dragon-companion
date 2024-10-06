<script setup lang="ts">
    import { PropType } from 'vue';
    import { PermissionBitwiseEnum, PermissionBitwiseUtils, PermissionEnum } from '../../types/entities/role/role-permission';
    import Checkbox from '../Checkbox.vue';

    defineProps({
        permissionName: { type: String as PropType<string>, required: true },
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
        <div class="">
            <Checkbox :checked="PermissionBitwiseUtils.hasPermission(permissions, PermissionEnum.Read)"
                :input-name="permissionName + '-read-checkbox'" :error="''" @update:checked="updatePermissions"
                :value="PermissionEnum.Read">Read
            </Checkbox>
        </div>
        <div class="">
            <Checkbox :checked="PermissionBitwiseUtils.hasPermission(permissions, PermissionEnum.Write)"
                :input-name="permissionName + '-write-checkbox'" :error="''" :value="PermissionEnum.Write"
                @update:checked="updatePermissions">Write</Checkbox>
        </div>
        <div class="">
            <Checkbox :checked="PermissionBitwiseUtils.hasPermission(permissions, PermissionEnum.Delete)"
                :input-name="permissionName + '-delete-checkbox'" :error="''" :value="PermissionEnum.Delete"
                @update:checked="updatePermissions">Delete</Checkbox>
        </div>
    </div>
</template>