<script setup lang="ts">
    import RoleTableRow from './RoleTableRow.vue';
    import { RolePermissionEntityInterface } from '../../types/entities/role/role-permission';

    const role = defineModel<RolePermissionEntityInterface>('role', { required: true })
</script>
<template>
    <table class="">
        <thead>
            <tr>
                <th>Campaign</th>
                <th>Items</th>
                <th>Timelines</th>
                <th>Species</th>
                <th>Characters</th>
                <th>Monsters</th>
            </tr>
        </thead>
        <tbody>
            <RoleTableRow v-model:role="role"></RoleTableRow>
        </tbody>
    </table>
</template>