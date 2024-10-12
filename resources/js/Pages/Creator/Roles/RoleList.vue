<script setup lang="ts">
    import { Head } from '@inertiajs/vue3';
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
    import PageHeader from '../../../Components/page-header/PageHeader.vue';
    import { useCampaignStore } from '../../../stores';
    import { PropType } from 'vue';
    import { RolePermissionEntityInterface } from '../../../types/entities/role/role-permission';
    import { CollectionInterface } from '../../../types/resource';
    import RolePermissionSection from '../../../Partials/RolePermissionSection/RolePermissionSection.vue';
    import LinkButton from '../../../Components/buttons/LinkButton.vue';

    defineProps({
        roles: { type: Object as PropType<CollectionInterface<RolePermissionEntityInterface>>, required: true }
    })

    const campaignStore = useCampaignStore();

</script>
<template>

    <Head title="Roles & Permissions" />
    <CreatorDefaultContentLayout>
        <PageHeader>
            <template #title>Roles</template><template #action>
                <LinkButton
                    :href="route('creator.campaigns.roles.create', { campaign: campaignStore.selectedCampaignId })"
                    :icon="['fas', 'plus']">Add role</LinkButton>
            </template>
        </PageHeader>
        <div>
            <p>The creator of a campaign will <strong>ALWAYS</strong> have permission to read/write/delete any entity
                in the campaign.</p>
            <p><strong>Admin</strong> level roles will be able to edit Roles and Permissions, so be careful who you add!
            </p>
        </div>
        <div v-for="role in roles.data">
            <RolePermissionSection :role="role"></RolePermissionSection>
        </div>
    </CreatorDefaultContentLayout>
</template>