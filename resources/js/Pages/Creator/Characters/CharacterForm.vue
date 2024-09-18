<script setup lang="ts">
    import { ref, watch } from 'vue'
    import EntityButtonWrapper from '../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
    import { type CharacterEntityInterface } from '../../services/character'
    import LoadingPage from '../../Components/loading-page/LoadingPage.vue';
    import { useCampaignStore, useSpeciesStore } from '../../stores';
    import type SelectInputOptionInterface from '../../Components/elements/interface/select-input-option.interface';
    import SelectInput from '../../Components/fields/SelectInput.vue';
    import TextArea from '../../Components/fields/TextArea.vue'
    import BaseInput from '../../Components/fields/BaseInput.vue'

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
            <form @submit.prevent="submitForm" class="flex flex-col gap-default md:gap-default-md">
                <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-default md:gap-default-md">
                    <div class="">
                        <BaseInput type="text" inputName="name" v-model:model="character.name" label="Character Name"
                            :require="true">
                        </BaseInput>
                    </div>
                    <div class="">
                        <SelectInput inputName="species" v-model:model="character.species_id" label="Species"
                            :options="speciesOptions">
                        </SelectInput>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 w-full gap-default md:gap-default-md">
                    <div class="">
                        <BaseInput type="number" inputName="age" v-model:model="character.age" label="Age">
                        </BaseInput>
                    </div>
                    <div class="">
                        <BaseInput type="number" inputName="maxHitPoints" v-model:model="character.max_hit_points"
                            label="Max hit points"></BaseInput>
                    </div>
                    <div class="">
                        <BaseInput type="number" inputName="armourClass" v-model:model="character.armour_class"
                            label="Armour class"></BaseInput>
                    </div>
                    <div class="">
                        <BaseInput type="number" inputName="dexterityModifier"
                            v-model:model="character.dexterity_modifier" label="Dexterity modifier"></BaseInput>
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
