<script setup lang="ts">
import TextInput from '../../components/elements/TextInput.vue';

const emit = defineEmits(['saveCampaign'])
const props = defineProps<{
    data?: {
        name?: string,
        synopsis?: string,
    }
}>()

let formData: {
    name?: string,
    synopsis?: string,
} = {}

if (props.data) {
    formData = props.data
}

function submitForm() {
    emit('saveCampaign', formData)
}

// function updateValue(property: string, value: string) {
//     formData[property] = value
// }
</script>

<template>
    <form @submit.prevent="submitForm">
        <pre>
name: {{ formData.name }}
synopsis: {{ formData.synopsis }}
        </pre>
        <!-- <TextInput inputName="name" :inputValue="props.data?.name" label="Campaign Name" @update-value="updateValue" /> -->
        <TextInput inputName="name" v-model="formData.name" label="Campaign Name" />
        <!-- <TextInput inputName="synopsis" :inputValue="props.data?.synopsis" label="Synopsis of campaign" @update-value="updateValue" /> -->
        <TextInput inputName="synopsis" v-model="formData.synopsis" label="Synopsis of campaign" />
        <input type="submit" value="Submit" />
    </form>
</template>