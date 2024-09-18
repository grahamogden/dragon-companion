<script setup lang="ts">
    import TextInput from '../../Components/Fields/TextInput.vue'
    import TextArea from '../../Components/Fields/TextArea.vue'
    import EntityButtonWrapper from '../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { TimelineEntityInterface, NewTimelineEntityInterface } from '../../services/timeline'
    import type SelectInputOptionInterface from '../../Components/elements/interface/select-input-option.interface'
    import SelectInput from '../../Components/Fields/SelectInput.vue'
    import { useTimelineStore } from '../../stores';
    import { ref, watch } from 'vue';
    import LoadingPage from '../../Components/loading-page/LoadingPage.vue';
    import BaseInput from '../../Components/Fields/BaseInput.vue'

    const isLoading = ref<boolean>(true)
    const timeline = defineModel<TimelineEntityInterface>('timeline', { required: true })
    const props = defineProps<{
        campaignId: number,
        isParentLoading: boolean,
    }>()

    const timelineStore = useTimelineStore()
    const timelineOptions: SelectInputOptionInterface[] = [
        { value: null, text: '-- No parent --' }
    ];

    function fetchTimelineOptions() {
        timelineStore.findTimelines(props.campaignId)
            .then((timelines) => {
                timelines.forEach((timelineRes) => {
                    if (timelineRes.id && timelineRes.id !== timeline.value.id) {
                        timelineOptions.push({ value: timelineRes.id, text: timelineRes.title })
                    }
                })
                isLoading.value = false
            })
    }

    if (props.isParentLoading) {
        // Watch for when the parent stops loading
        watch(() => props.isParentLoading, (isLoading) => {
            if (!isLoading) {
                fetchTimelineOptions()
            }
        })
    } else {
        // Has the parent already finished loading or
        // not needed to load anything to begin with
        fetchTimelineOptions()
    }
</script>

<template>
    <LoadingPage :is-loading="isLoading">
        <template #content>
            <form @submit.prevent="submitForm" class="flex flex-row flex-wrap gap-default md:gap-default-md">
                <div class="w-full md:w-auto grow">
                    <BaseInput type="text" inputName="title" v-model:model="timeline.title" label="Title"
                        :require="true"></BaseInput>
                </div>
                <div class="w-full md:w-auto grow">
                    <SelectInput v-model:model="timeline.parent_id" label="Parent timeline" input-name="parent_id"
                        :options="timelineOptions"></SelectInput>
                </div>
                <div class="w-full">
                    <TextArea input-name="body" v-model:model="timeline.body" label="Body" :require="true"></TextArea>
                </div>
                <EntityButtonWrapper :cancelDestination="{ name: 'timelines.list' }" />
            </form>
        </template>
        <template #loading-text>timeline</template>
    </LoadingPage>
</template>
