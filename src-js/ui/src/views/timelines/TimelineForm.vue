<script setup lang="ts">
    import TextInput from '../../components/fields/TextInput.vue'
    import TextArea from '../../components/fields/TextArea.vue'
    import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { TimelineEntityInterface, NewTimelineEntityInterface } from '../../services/timeline'
    import type SelectInputOptionInterface from '../../components/elements/interface/select-input-option.interface'
    import SelectInput from '../../components/fields/SelectInput.vue'
    import { useTimelineStore } from '../../stores';
    import { ref, watch } from 'vue';
    import LoadingPage from '../../components/loading-page/LoadingPage.vue';

    const isLoading = ref<boolean>(true)
    const timeline = defineModel<TimelineEntityInterface>('timeline', { required: true })
    const props = defineProps<{
        campaignId: number,
        isParentLoading: boolean,
    }>()

    const timelineStore = useTimelineStore()
    const timelineOptions: SelectInputOptionInterface[] = [];

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

    const emit = defineEmits(['saveTimeline'])
    function submitForm() {
        emit('saveTimeline')
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
    <loading-page :is-loading="isLoading">
        <template #content>
            <form @submit.prevent="submitForm" class="flex flex-row flex-wrap">
                <div class="w-full md:w-2/4">
                    <text-input inputName="title" v-model:model="timeline.title" label="Title" :require="true" />
                </div>
                <div class="w-full md:w-2/4">
                    <select-input v-model:model="timeline.parent_id" label="Parent timeline" input-name="parent_id"
                        :options="timelineOptions" />
                </div>
                <div class="w-full">
                    <text-area input-name="body" v-model:model="timeline.body" label="Body" />
                </div>
                <EntityButtonWrapper :cancelDestination="{ name: 'timelines.list' }" />
            </form>
        </template>
        <template #loading-text>timeline</template>
    </loading-page>
</template>
