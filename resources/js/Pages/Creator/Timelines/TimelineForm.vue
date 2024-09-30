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
        parent_id: props.timeline?.parent_id ?? props.parent?.id ?? '',
    })

    const saveTimeline = () => {
        if (props.timeline) {
            form.put(route('creator.campaigns.timelines.update', { campaign: campaignStore.selectedCampaignId, timeline: props.timeline.id }))
        } else {
            form.post(route('creator.campaigns.timelines.store', { campaign: campaignStore.selectedCampaignId }))
        }
    }

    // const isLoading = ref<boolean>(true)
    // const timeline = defineModel<TimelineEntityInterface>('timeline', { required: true })
    // const props = defineProps<{
    //     campaignId: number,
    //     isParentLoading: boolean,
    // }>()

    // const timelineStore = useTimelineStore()
    // const timelineOptions: SelectInputOptionInterface[] = [
    //     { value: null, text: '-- No parent --' }
    // ];

    // function fetchTimelineOptions() {
    //     timelineStore.findTimelines(props.campaignId)
    //         .then((timelines) => {
    //             timelines.forEach((timelineRes) => {
    //                 if (timelineRes.id && timelineRes.id !== timeline.value.id) {
    //                     timelineOptions.push({ value: timelineRes.id, text: timelineRes.title })
    //                 }
    //             })
    //             isLoading.value = false
    //         })
    // }

    // if (props.isParentLoading) {
    //     // Watch for when the parent stops loading
    //     watch(() => props.isParentLoading, (isLoading) => {
    //         if (!isLoading) {
    //             fetchTimelineOptions()
    //         }
    //     })
    // } else {
    //     // Has the parent already finished loading or
    //     // not needed to load anything to begin with
    //     fetchTimelineOptions()
    // }
</script>

<template>

    <Head :title="(timeline ? 'Edit ' + timeline.name : 'Create a') + ' Timeline Event'" />
    <form @submit.prevent="saveTimeline">
        <CreatorDefaultContentLayout>
            <div class="w-full md:w-2/4">
                <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name"
                    label=" Name" :require="true">
                </BaseInput>
            </div>
            <div class="w-full md:w-2/4">
                <!-- <SelectInput v-model:model="form.parent_id" :error="form.errors.parent_id" label="Parent timeline"
                    input-name="parent_id" :options="[]">
                </SelectInput> -->
                <div v-if="parent">Parent timeline: {{ parent.name }}</div>
                <BaseInput v-else type="number" v-model:model="form.parent_id" input-name="parent_id"
                    label="Parent timeline" :error="form.errors.parent_id" />
            </div>
            <div class="w-full">
                <TextArea input-name="description" v-model:model="form.description" :error="form.errors.description"
                    label="Description"></TextArea>
            </div>
            <EntityButtonWrapper />
        </CreatorDefaultContentLayout>
    </form>
</template>
