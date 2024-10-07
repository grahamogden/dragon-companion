<script setup lang="ts">
    import { Head } from '@inertiajs/vue3';
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
    import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
    import { useCampaignStore } from '../../../stores';
    import { PropType } from 'vue';
    import { RolePermissionEntityInterface } from '../../../types/entities/role/role-permission';
    import { CollectionInterface } from '../../../types/resource';
    import RolePermissionSection from '../../../Partials/RolePermissionSection/RolePermissionSection.vue';

    defineProps({
        roles: { type: Object as PropType<CollectionInterface<RolePermissionEntityInterface>>, required: true }
    })

    const campaignStore = useCampaignStore();

</script>
<template>

    <Head title="Roles & Permissions" />
    <CreatorDefaultContentLayout>
        <PageHeaderWithLink
            :href="route('creator.campaigns.roles.create', { campaign: campaignStore.selectedCampaignId })">
            <template #title>Roles</template><template #link><font-awesome-icon :icon="['fas', 'plus']" fixed-width
                    class="mr-2" />Add role</template>
        </PageHeaderWithLink>
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