<script setup lang="ts">
    import { PropType } from 'vue';
    import EntityButtonWrapper from '../../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { ItemEntityInterface } from '../../../types/entities/item'
    import { useCampaignStore } from '../../../stores';
    import { Head, useForm } from '@inertiajs/vue3';
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
    import BaseInput from '../../../Components/Fields/BaseInput.vue';
    import PageHeader from '../../../Components/page-header/PageHeader.vue';

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

    const title = (props.item ? 'Edit ' + props.item.name : 'Create an') + ' Item'
</script>

<template>

    <Head :title="title" />
    <form @submit.prevent="saveItem">
        <CreatorDefaultContentLayout>
            <PageHeader><template #title>{{ title }}</template></PageHeader>
            <div class="w-full md:w-2/4">
                <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name"
                    label="Item Name" :isRequired="true">
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
