<script setup lang="ts">
    import TextInput from '../../components/elements/TextInput.vue'
    import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { SpeciesEntityInterface } from '../../services/species'
    import LoadingPage from '../../components/loading-page/LoadingPage.vue';

    const species = defineModel<SpeciesEntityInterface>('species', { required: true })

    const props = defineProps<{
        isParentLoading: boolean
    }>()
        
    const emit = defineEmits(['saveSpecies'])
    function submitForm() {
        emit('saveSpecies')
    }
</script>

<template>
    <loading-page v-model="props.isParentLoading">
        <template #content>
            <form @submit.prevent="submitForm">
                <div class="w-full md:w-2/4">
                    <TextInput inputName="name" v-model="species.name" label="Species Name" />
                </div>
                <EntityButtonWrapper :cancelDestination="{ name: 'species.list' }" />
            </form>
        </template>
        <template #loading-text>species</template>
    </loading-page>
</template>
