<script setup lang="ts">
    import TextInput from '../../components/fields/TextInput.vue'
    import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { SpeciesEntityInterface } from '../../services/species'
    import LoadingPage from '../../components/loading-page/LoadingPage.vue';
    import BaseInput from '../../components/fields/BaseInput.vue';

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
    <LoadingPage :is-loading="props.isParentLoading">
        <template #content>
            <form @submit.prevent="submitForm" class="flex flex-row flex-wrap gap-6">
                <div class="w-full md:w-2/4">
                    <BaseInput type="text" inputName="name" v-model:model="species.name" label="Species Name"
                        :require="true">
                    </BaseInput>
                </div>
                <EntityButtonWrapper :cancelDestination="{ name: 'species.list' }" />
            </form>
        </template>
        <template #loading-text>species</template>
    </LoadingPage>
</template>
