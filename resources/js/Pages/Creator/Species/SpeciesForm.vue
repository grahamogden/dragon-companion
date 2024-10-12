<script setup lang="ts">
    import EntityButtonWrapper from '../../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { SpeciesEntityInterface } from '../../../types/entities/species'
    import BaseInput from '../../../Components/Fields/BaseInput.vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import { useCampaignStore } from '../../../stores';
    import { PropType } from 'vue';
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';

    const props = defineProps({
        species: { type: Object as PropType<SpeciesEntityInterface>, required: false }
    })

    const campaignStore = useCampaignStore()

    const form = useForm({
        name: props.species?.name ?? '',
        description: props.species?.description ?? '',
    })

    const saveSpecies = () => {
        if (props.species) {
            form.put(route('creator.campaigns.species.update', { campaign: campaignStore.selectedCampaignId, species: props.species.id }))
        } else {
            form.post(route('creator.campaigns.species.store', { campaign: campaignStore.selectedCampaignId }))
        }
    }
</script>

<template>

    <Head :title="(species ? 'Edit ' + species.name : 'Create an') + ' Species'" />
    <form @submit.prevent="saveSpecies">
        <CreatorDefaultContentLayout>
            <div class="w-full md:w-2/4">
                <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name" label="Name"
                    is-required>
                </BaseInput>
            </div>
            <div class="w-full">
                <BaseInput type="text" inputName="description" v-model:model="form.description"
                    :error="form.errors.description" label="Description">
                </BaseInput>
            </div>
            <EntityButtonWrapper
                :cancelDestination="route('creator.campaigns.species.index', { campaign: campaignStore.selectedCampaignId })" />
        </CreatorDefaultContentLayout>
    </form>
</template>
