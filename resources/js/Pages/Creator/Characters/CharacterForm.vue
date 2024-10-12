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
    import { CollectionInterface } from '../../../types/resource';
    import { SelectInputOptionInterface } from '../../../types/entity-option';
    import PageHeader from '../../../Components/page-header/PageHeader.vue';

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

    const title = (props.character ? 'Edit ' + props.character.name : 'Create a') + ' Character'
</script>

<template>

    <Head :title="title" />
    <form @submit.prevent="saveCharacter">
        <CreatorDefaultContentLayout>
            <PageHeader><template #title>{{ title }}</template></PageHeader>
            <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-default md:gap-default-md">
                <div class="">
                    <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name"
                        label="Character Name" :isRequired="true">
                    </BaseInput>
                </div>
                <div class="">
                    <SelectInput inputName="species" v-model:model="form.species_id" :error="form.errors.species_id"
                        label="Species" :options="species.data" inlcude-null-value editable>
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
