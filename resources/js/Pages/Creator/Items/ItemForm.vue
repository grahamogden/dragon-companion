<script setup lang="ts">
    import { PropType } from 'vue';
    import EntityButtonWrapper from '../../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { ItemEntityInterface } from '../../../types/entities/item'
    import { useCampaignStore } from '../../../stores';
    import { Head, useForm } from '@inertiajs/vue3';
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
    import BaseInput from '../../../Components/Fields/BaseInput.vue';

    const props = defineProps({
        item: { type: Object as PropType<ItemEntityInterface>, required: false }
    })

    const campaignStore = useCampaignStore()

    const form = useForm({
        name: props.item?.name ?? '',
        description: props.item?.description ?? '',
    })

    const saveItem = () => {
        if (props.item) {
            form.put(route('creator.campaigns.items.update', { campaign: campaignStore.selectedCampaignId, item: props.item.id }))
        } else {
            form.post(route('creator.campaigns.items.store', { campaign: campaignStore.selectedCampaignId }))
        }
    }
</script>

<template>

    <Head :title="(item ? 'Edit ' + item.name : 'Create an') + ' Item'" />
    <form @submit.prevent="saveItem">
        <CreatorDefaultContentLayout>
            <div class="w-full md:w-2/4">
                <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name"
                    label="Item Name" :require="true">
                </BaseInput>
            </div>
            <div class="w-full">
                <BaseInput type="text" inputName="description" v-model:model="form.description"
                    :error="form.errors.description" label="Description"></BaseInput>
            </div>
            <EntityButtonWrapper
                :cancelDestination="route('creator.campaigns.items.index', { campaign: campaignStore.selectedCampaignId })">
            </EntityButtonWrapper>
        </CreatorDefaultContentLayout>
    </form>
</template>
