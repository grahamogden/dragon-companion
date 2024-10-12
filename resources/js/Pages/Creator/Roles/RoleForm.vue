<script setup lang="ts">
    import { Head, useForm } from '@inertiajs/vue3';
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
    import { PropType } from 'vue';
    import { PermissionBitwiseEnum, RolePermissionEntityInterface } from '../../../types/entities/role/role-permission';
    import { useCampaignStore } from '../../../stores';
    import RoleFormTable from '../../../Components/RoleTable/RoleFormTable.vue';
    import { ResourceInterface } from '../../../types/resource';
    import PageHeader from '../../../Components/page-header/PageHeader.vue';
    import EntityButtonWrapper from '../../../Components/entity-button-wrapper/EntityButtonWrapper.vue';
    import BaseInput from '../../../Components/Fields/BaseInput.vue';
    import SelectInput from '../../../Components/Fields/SelectInput.vue';
    import { EnumUtils } from '../../../types/enum.utils';
    import { RoleLevelEnum } from '../../../types/entities/role';

    const props = defineProps({
        role: { type: Object as PropType<ResourceInterface<RolePermissionEntityInterface>>, required: false }
    })

    const form = useForm<RolePermissionEntityInterface>({
        name: props.role?.data.name ?? '',
        role_level: props.role?.data.role_level ?? RoleLevelEnum.Custom,
        rolePermission: {
            campaign_permissions: props.role?.data.rolePermission.campaign_permissions ?? PermissionBitwiseEnum.Deny,
            item_permissions: props.role?.data.rolePermission.item_permissions ?? PermissionBitwiseEnum.Deny,
            timeline_permissions: props.role?.data.rolePermission.timeline_permissions ?? PermissionBitwiseEnum.Deny,
            species_permissions: props.role?.data.rolePermission.species_permissions ?? PermissionBitwiseEnum.Deny,
            character_permissions: props.role?.data.rolePermission.character_permissions ?? PermissionBitwiseEnum.Deny,
            monster_permissions: props.role?.data.rolePermission.monster_permissions ?? PermissionBitwiseEnum.Deny,
        }
    })

    const campaignStore = useCampaignStore()

    const saveRole = () => {
        if (props.role) {
            form.put(route('creator.campaigns.roles.update', { campaign: campaignStore.selectedCampaignId, role: props.role.data.id }))
        } else {
            form.post(route('creator.campaigns.roles.store', { campaign: campaignStore.selectedCampaignId }))
        }
    }
    const pageTitle = (props.role ? 'Edit "' + props.role.data.name + '"' : 'Create a') + ' Role'
</script>
<template>

    <Head :title="pageTitle" />
    <form @submit.prevent="saveRole">
        <CreatorDefaultContentLayout>
            <PageHeader><template #title>{{ pageTitle }}</template></PageHeader>
            <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-default md:gap-default-md">
                <div class="">
                    <BaseInput type="text" inputName="role_name" v-model:model="form.name" :error="form.errors.name"
                        label="Role name" is-required />
                </div>
                <div class="">
                    <SelectInput input-name="role_level" v-model:model="form.role_level" :error="form.errors.role_level"
                        :options="EnumUtils.getSelectOptions(RoleLevelEnum)" label="Role type" is-required>
                    </SelectInput>
                </div>
            </div>
            <RoleFormTable v-model:role="form"></RoleFormTable>
            <EntityButtonWrapper
                :cancel-destination="route('creator.campaigns.roles.index', { campaign: campaignStore.selectedCampaignId })">
            </EntityButtonWrapper>
        </CreatorDefaultContentLayout>
    </form>
</template>