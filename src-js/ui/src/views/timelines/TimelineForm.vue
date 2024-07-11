<script setup lang="ts">
import TextInput from '../../components/elements/TextInput.vue'
import TextArea from '../../components/elements/TextArea.vue'
import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
import type { TimelineEntityInterface, NewTimelineEntityInterface } from '../../services/timeline'
import { TimelineEntity } from '../../services/timeline'

const emit = defineEmits(['saveTimeline'])
const props = defineProps<{
    data?: TimelineEntityInterface
}>()

let formData: NewTimelineEntityInterface = new TimelineEntity(
    props.data?.id,
    props.data?.title,
    props.data?.body,
    props.data?.parent_id,
);

if (props.data) {
    formData = props.data
}

function submitForm() {
    emit('saveTimeline', formData)
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="w-full md:w-2/4">
            <TextInput inputName="name" v-model="formData.title" label="Title" />
        </div>
        <div class="w-full">
            <TextArea inputName="name" v-model="formData.body" label="Body" />
        </div>
        <EntityButtonWrapper :cancelDestination="{ name: 'timelines.list'}" />
    </form>
</template>
