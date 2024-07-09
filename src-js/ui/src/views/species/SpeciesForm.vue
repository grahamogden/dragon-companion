<script setup lang="ts">
import TextInput from '../../components/elements/TextInput.vue'
import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
import type { SpeciesEntityInterface, NewSpeciesEntityInterface } from '../../services/species'
import { SpeciesEntity } from '../../services/species'

const emit = defineEmits(['saveSpecies'])
const props = defineProps<{
    data?: SpeciesEntityInterface
}>()

let formData: NewSpeciesEntityInterface = new SpeciesEntity(
    props.data?.id,
    props.data?.name,
);

if (props.data) {
    formData = props.data
}

function submitForm() {
    emit('saveSpecies', formData)
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="w-full md:w-2/4">
            <TextInput inputName="name" v-model="formData.name" label="Species Name" />
        </div>
        <EntityButtonWrapper :cancelDestination="{ name: 'species.list'}" />
    </form>
</template>
