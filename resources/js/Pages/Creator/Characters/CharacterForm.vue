<script setup lang="ts">
    import { PropType } from 'vue'
    import EntityButtonWrapper from '../../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
    import { type CharacterEntityInterface } from '../../../types/entities/character'
    import { useCampaignStore } from '../../../stores';
    import SelectInput from '../../../Components/Fields/SelectInput.vue';
    import TextArea from '../../../Components/Fields/TextArea.vue'
    import BaseInput from '../../../Components/Fields/BaseInput.vue'
    import { Head, useForm } from '@inertiajs/vue3';
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
    import { CollectionInterface } from '../../../types/collection';
    import { SelectInputOptionInterface } from '../../../types/entity-option';

    const props = defineProps({
        character: { type: Object as PropType<CharacterEntityInterface>, required: false },
        species: { type: Object as PropType<CollectionInterface<SelectInputOptionInterface>>, required: true }
    })

    const campaignStore = useCampaignStore()

    const form = useForm({
        name: props.character?.name ?? '',
        age: props.character?.age ?? '',
        max_hit_points: props.character?.max_hit_points ?? '',
        armour_class: props.character?.armour_class ?? '',
        dexterity_modifier: props.character?.dexterity_modifier ?? '',
        appearance: props.character?.appearance ?? '',
        notes: props.character?.notes ?? '',
        species_id: props.character?.species_id ?? null,
    })

    const saveCharacter = () => {
        if (props.character) {
            form.put(route('creator.campaigns.characters.update', { campaign: campaignStore.selectedCampaignId, character: props.character.id }))
        } else {
            form.post(route('creator.campaigns.characters.store', { campaign: campaignStore.selectedCampaignId }))
        }
    }

    // const speciesOptions = props.species.data.map((species: SpeciesEntityInterface): SelectInputOptionInterface => ({
    //     value: species.id!,
    //     text: species.name,
    // }))

    // const props = defineProps<{
    //     isParentLoading: boolean
    // }>()

    // const speciesOptions: SelectInputOptionInterface[] = [
    //     { value: null, text: '-- No species --' }
    // ];

    // function fetchSpeciesOptions() {
    //     speciesStore.fetchSpecies(campaignStore.selectedCampaignId!)
    //         .then((species) => {
    //             species.forEach((speciesRes) => {
    //                 if (speciesRes.id && speciesRes.id !== character.value.species_id) {
    //                     speciesOptions.push({ value: speciesRes.id, text: speciesRes.name })
    //                 }
    //             })
    //             isLoading.value = false
    //         })
    // }

    // if (props.isParentLoading) {
    //     // Watch for when the parent stops loading
    //     watch(() => props.isParentLoading, (isLoading) => {
    //         if (!isLoading) {
    //             fetchSpeciesOptions()
    //         }
    //     })
    // } else {
    //     // Has the parent already finished loading or
    //     // not needed to load anything to begin with
    //     fetchSpeciesOptions()
    // }
</script>

<template>

    <Head :title="(character ? 'Edit ' + character.name : 'Create an') + ' Item'" />
    <form @submit.prevent="saveCharacter">
        <CreatorDefaultContentLayout>
            <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-default md:gap-default-md">
                <div class="">
                    <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name"
                        label="Character Name" :isRequired="true">
                    </BaseInput>
                </div>
                <div class="">
                    <SelectInput inputName="species" v-model:model="form.species_id" :error="form.errors.species_id"
                        label="Species" :options="species.data" inlcude-null-value>
                    </SelectInput>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 w-full gap-default md:gap-default-md">
                <div class="">
                    <BaseInput type="number" inputName="age" v-model:model="form.age" :error="form.errors.age"
                        label="Age">
                    </BaseInput>
                </div>
                <div class="">
                    <BaseInput type="number" inputName="maxHitPoints" v-model:model="form.max_hit_points"
                        :error="form.errors.max_hit_points" label="Max hit points"></BaseInput>
                </div>
                <div class="">
                    <BaseInput type="number" inputName="armourClass" v-model:model="form.armour_class"
                        :error="form.errors.armour_class" label="Armour class"></BaseInput>
                </div>
                <div class="">
                    <BaseInput type="number" inputName="dexterityModifier" v-model:model="form.dexterity_modifier"
                        :error="form.errors.dexterity_modifier" label="Dexterity modifier"></BaseInput>
                </div>
            </div>
            <div class="w-full">
                <TextArea inputName="appearance" v-model:model="form.appearance" :error="form.errors.appearance"
                    label="Appearance"></TextArea>
            </div>
            <div class="w-full">
                <TextArea inputName="notes" v-model:model="form.notes" :error="form.errors.notes" label="Notes">
                    </TextArea>
            </div>
            <EntityButtonWrapper
                :cancelDestination="route('creator.campaigns.characters.index', { campaign: campaignStore.selectedCampaignId })">
            </EntityButtonWrapper>
        </CreatorDefaultContentLayout>
    </form>
</template>
