<script setup lang="ts">
    import { ref, watch } from 'vue'
    import TextInput from '../../components/fields/TextInput.vue'
    import NumberInput from '../../components/fields/NumberInput.vue'
    import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
    import { type CharacterEntityInterface } from '../../services/character'
    import LoadingPage from '../../components/loading-page/LoadingPage.vue';
    import { useCampaignStore, useSpeciesStore } from '../../stores';
    import type SelectInputOptionInterface from '../../components/elements/interface/select-input-option.interface';
    import SelectInput from '../../components/fields/SelectInput.vue';
    import TextArea from '../../components/fields/TextArea.vue'

    const isLoading = ref<boolean>(true)
    const campaignStore = useCampaignStore()
    const speciesStore = useSpeciesStore()
    const character = defineModel<CharacterEntityInterface>('character', { required: true })

    const props = defineProps<{
        isParentLoading: boolean
    }>()

    const speciesOptions: SelectInputOptionInterface[] = [
        { value: null, text: '-- No species --' }
    ];

    function fetchSpeciesOptions() {
        speciesStore.fetchSpecies(campaignStore.selectedCampaignId!)
            .then((species) => {
                species.forEach((speciesRes) => {
                    if (speciesRes.id && speciesRes.id !== character.value.species_id) {
                        speciesOptions.push({ value: speciesRes.id, text: speciesRes.name })
                    }
                })
                isLoading.value = false
            })
    }

    const emit = defineEmits(['saveCharacter'])
    function submitForm() {
        emit('saveCharacter')
    }

    if (props.isParentLoading) {
        // Watch for when the parent stops loading
        watch(() => props.isParentLoading, (isLoading) => {
            if (!isLoading) {
                fetchSpeciesOptions()
            }
        })
    } else {
        // Has the parent already finished loading or
        // not needed to load anything to begin with
        fetchSpeciesOptions()
    }
</script>

<template>
    <loading-page :is-loading="props.isParentLoading">
        <template #content>
            <form @submit.prevent="submitForm" class="flex flex-col gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6">
                    <div class="">
                        <TextInput inputName="name" v-model:model="character.name" label="Character Name"
                            :require="true">
                        </TextInput>
                    </div>
                    <div class="">
                        <SelectInput inputName="species" v-model:model="character.species_id" label="Species"
                            :options="speciesOptions">
                        </SelectInput>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 w-full gap-6">
                    <div class="">
                        <NumberInput inputName="age" v-model:model="character.age" label="Age">
                        </NumberInput>
                    </div>
                    <div class="">
                        <NumberInput inputName="maxHitPoints" v-model:model="character.max_hit_points"
                            label="Max hit points"></NumberInput>
                    </div>
                    <div class="">
                        <NumberInput inputName="armourClass" v-model:model="character.armour_class"
                            label="Armour class"></NumberInput>
                    </div>
                    <div class="">
                        <NumberInput inputName="dexterityModifier" v-model:model="character.dexterity_modifier"
                            label="Dexterity modifier"></NumberInput>
                    </div>
                </div>
                <div class="w-full">
                    <TextArea inputName="appearance" v-model:model="character.appearance" label="Appearance"></TextArea>
                </div>
                <div class="w-full">
                    <TextArea inputName="notes" v-model:model="character.notes" label="Notes">
                    </TextArea>
                </div>
                <EntityButtonWrapper :cancelDestination="{ name: 'characters.list' }"></EntityButtonWrapper>
            </form>
        </template>
        <template #loading-text>character</template>
    </loading-page>
</template>
