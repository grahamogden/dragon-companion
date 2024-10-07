<script setup lang="ts">
    import { PropType } from 'vue';
    import { PermissionBitwiseEnum, RolePermissionEntityInterface } from '../../types/entities/role/role-permission';
    import { IndexDestroyEntityInterface } from '../../types/entities/entity.interface';
    import { router, useForm } from '@inertiajs/vue3';
    import RolePermissionCheckBoxGroup from '../../Components/RoleTable/RolePermissionCheckBoxGroup.vue';
    import { useCampaignStore, useNotificationStore } from '../../stores';
    import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';
    import HorizontalRule from '../../Components/horizontal-rule/HorizontalRule.vue';
    import { RoleLevelEnum } from '../../types/entities/role';
    import SelectInput from '../../Components/Fields/SelectInput.vue';
    import { EnumUtils } from '../../types/enum.utils';
    import BaseInput from '../../Components/Fields/BaseInput.vue';

    const props = defineProps({
        role: { type: Object as PropType<RolePermissionEntityInterface>, required: true },
    })

    const deleteEntity = (entity: IndexDestroyEntityInterface) => {
        if (entity.destroy_url) {
            if (confirm('Are you sure you want to delete this role?')) {
                router.delete(entity.destroy_url)
            }
        } else {
            alert('Nothing to delete!')
        }
    }

    const form = useForm<RolePermissionEntityInterface>({
        name: props.role.name ?? '',
        role_level: props.role.role_level ?? RoleLevelEnum.Custom,
        rolePermission: {
            campaign_permissions: props.role.rolePermission.campaign_permissions ?? PermissionBitwiseEnum.Deny,
            item_permissions: props.role.rolePermission.item_permissions ?? PermissionBitwiseEnum.Deny,
            timeline_permissions: props.role.rolePermission.timeline_permissions ?? PermissionBitwiseEnum.Deny,
            species_permissions: props.role.rolePermission.species_permissions ?? PermissionBitwiseEnum.Deny,
            character_permissions: props.role.rolePermission.character_permissions ?? PermissionBitwiseEnum.Deny,
            monster_permissions: props.role.rolePermission.monster_permissions ?? PermissionBitwiseEnum.Deny,
        }
    })

    const campaignStore = useCampaignStore()
    const notificationStore = useNotificationStore()

    const saveRole = () => {
        notificationStore.removeAllNotifications()

        if (props.role) {
            form.put(route('creator.campaigns.roles.update', { campaign: campaignStore.selectedCampaignId, role: props.role.id }))
        } else {
            form.post(route('creator.campaigns.roles.store', { campaign: campaignStore.selectedCampaignId }))
        }
    }
</script>
<template>
    <HorizontalRule />
    <form @submit.prevent="saveRole" class="grid gap-default mt-default">
        <div class="flex flex-col md:flex-row gap-default">
            <div class="w-full md:w-1/4">
                <BaseInput type="text" v-model:model="form.name" :input-name="'role_name-' + role.name.toLowerCase()"
                    :error="form.errors.name" label="Role name">
                </BaseInput>
            </div>
            <div class="w-full md:w-1/4">
                <SelectInput :input-name="'role_type' + role.name.toLowerCase()" v-model:model="form.role_level"
                    :options="EnumUtils.getSelectOptions(RoleLevelEnum)" label="Role type"></SelectInput>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-6 mb-default">
            <div class="">
                <div>Campaigns</div>
                <RolePermissionCheckBoxGroup permission-name="campaign_permissions"
                    v-model:permissions="form.rolePermission.campaign_permissions">
                </RolePermissionCheckBoxGroup>
            </div>
            <div class="">
                <div>Items</div>
                <RolePermissionCheckBoxGroup permission-name="item_permissions"
                    v-model:permissions="form.rolePermission.item_permissions">
                </RolePermissionCheckBoxGroup>
            </div>
            <div class="">
                <div>Timelines</div>
                <RolePermissionCheckBoxGroup permission-name="timeline_permissions"
                    v-model:permissions="form.rolePermission.timeline_permissions">
                </RolePermissionCheckBoxGroup>
            </div>
            <div class="">
                <div>Species</div>
                <RolePermissionCheckBoxGroup permission-name="species_permissions"
                    v-model:permissions="form.rolePermission.species_permissions">
                </RolePermissionCheckBoxGroup>
            </div>
            <div class="">
                <div>Characters</div>
                <RolePermissionCheckBoxGroup permission-name="character_permissions"
                    v-model:permissions="form.rolePermission.character_permissions">
                </RolePermissionCheckBoxGroup>
            </div>
            <div class="">
                <div>Monsters</div>
                <RolePermissionCheckBoxGroup permission-name="monster_permissions"
                    v-model:permissions="form.rolePermission.monster_permissions">
                </RolePermissionCheckBoxGroup>
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-center items-center gap-x-10 gap-y-6 w-full">
            <div class="md:order-last w-full md:w-auto text-center">
                <PrimaryButton>Save</PrimaryButton>
            </div>
            <div class="w-full md:w-auto text-center">
                <SecondaryButton :func="deleteEntity" :args="[role]" is-destructive>Delete</SecondaryButton>
            </div>
        </div>
    </form>
</template>