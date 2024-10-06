<script setup lang="ts">
    import { PropType } from 'vue';
    import { RolePermissionEntityInterface } from '../../types/entities/role/role-permission';
    import RolePermissionCheckBoxGroup from './RolePermissionCheckBoxGroup.vue';
    import { IndexDestroyEntityInterface } from '../../types/entities/entity.interface';
    import { Link, router } from '@inertiajs/vue3';
    import LinkButton from '../buttons/LinkButton.vue';
    import SecondaryButton from '../buttons/SecondaryButton.vue';

    defineProps({
        showRoleName: { type: Boolean as PropType<boolean>, required: false, default: false },
        isReadOnly: { type: Boolean as PropType<boolean>, required: false, default: false },
    })

    const role = defineModel<RolePermissionEntityInterface>('role', { required: true })

    const deleteEntity = (entity: IndexDestroyEntityInterface) => {
        if (entity.destroy_url) {
            if (confirm('Are you sure you want to delete this record?')) {
                router.delete(entity.destroy_url)
            }
        } else {
            alert('Nothing to delete!')
        }
    }
</script>
<template>
    <tr>
        <td v-if="showRoleName" class="">{{ role.name }}
            <Link :href="role.edit_url ?? ''">(Edit)</Link>
            <SecondaryButton :func="deleteEntity" :args="[role]">(Delete)</SecondaryButton>
        </td>
        <td>
            <RolePermissionCheckBoxGroup permission-name="campaign_permissions"
                v-model:permissions="role.rolePermission.campaign_permissions" :disabled="isReadOnly">
            </RolePermissionCheckBoxGroup>
        </td>
        <td>
            <RolePermissionCheckBoxGroup permission-name="item_permissions"
                v-model:permissions="role.rolePermission.item_permissions" :disabled="isReadOnly">
            </RolePermissionCheckBoxGroup>
        </td>
        <td>
            <RolePermissionCheckBoxGroup permission-name="timeline_permissions"
                v-model:permissions="role.rolePermission.timeline_permissions" :disabled="isReadOnly">
            </RolePermissionCheckBoxGroup>
        </td>
        <td>
            <RolePermissionCheckBoxGroup permission-name="species_permissions"
                v-model:permissions="role.rolePermission.species_permissions" :disabled="isReadOnly">
            </RolePermissionCheckBoxGroup>
        </td>
        <td>
            <RolePermissionCheckBoxGroup permission-name="character_permissions"
                v-model:permissions="role.rolePermission.character_permissions" :disabled="isReadOnly">
            </RolePermissionCheckBoxGroup>
        </td>
        <td>
            <RolePermissionCheckBoxGroup permission-name="monster_permissions"
                v-model:permissions="role.rolePermission.monster_permissions" :disabled="isReadOnly">
            </RolePermissionCheckBoxGroup>
        </td>
    </tr>
</template>