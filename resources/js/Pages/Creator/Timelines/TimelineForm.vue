<script setup lang="ts">
    import TextArea from '../../../Components/Fields/TextArea.vue'
    import EntityButtonWrapper from '../../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { TimelineEntityInterface } from '../../../types/entities/timeline'
    import { PropType } from 'vue';
    import BaseInput from '../../../Components/Fields/BaseInput.vue'
    import { useCampaignStore } from '../../../stores'
    import { Head, useForm } from '@inertiajs/vue3'
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue'

    const props = defineProps({
        timeline: { type: Object as PropType<TimelineEntityInterface>, required: false },
        parent: { type: Object as PropType<TimelineEntityInterface>, required: false },
        cancelLink: { type: String, required: false },
    })

    const campaignStore = useCampaignStore()

    const form = useForm({
        name: props.timeline?.name ?? '',
        description: props.timeline?.description ?? '',
        parent_id: props.timeline?.parent_id ?? props.parent?.id ?? null,
    })

    const saveTimeline = () => {
        if (props.timeline) {
            form.put(route('creator.campaigns.timelines.update', { campaign: campaignStore.selectedCampaignId, timeline: props.timeline.id }))
        } else {
            form.post(route('creator.campaigns.timelines.store', { campaign: campaignStore.selectedCampaignId }))
        }
    }
</script>

<template>

    <Head :title="(timeline ? 'Edit ' + timeline.name : 'Create a') + ' Timeline Event'" />
    <form @submit.prevent="saveTimeline">
        <CreatorDefaultContentLayout>
            <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-default md:gap-default-md">
                <div class="">
                    <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name"
                        label=" Name" :isRequired="true">
                    </BaseInput>
                </div>
                <div class="">
                    <div v-if="parent">Parent timeline: {{ parent.name }}</div>
                    <BaseInput v-else type="number" v-model:model="form.parent_id" input-name="parent_id"
                        label="Parent timeline" :error="form.errors.parent_id" />
                </div>
            </div>
            <div class="w-full">
                <TextArea input-name="description" v-model:model="form.description" :error="form.errors.description"
                    label="Description"></TextArea>
            </div>
            <EntityButtonWrapper go-back />
        </CreatorDefaultContentLayout>
    </form>
</template>
