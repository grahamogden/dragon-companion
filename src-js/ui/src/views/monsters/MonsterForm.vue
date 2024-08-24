<script setup lang="ts">
    import { ref, watch } from 'vue'
    import TextInput from '../../components/fields/TextInput.vue'
    import NumberInput from '../../components/fields/NumberInput.vue'
    import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
    import { type MonsterEntityInterface } from '../../services/monster'
    import LoadingPage from '../../components/loading-page/LoadingPage.vue';
    import { useCampaignStore, useSpeciesStore } from '../../stores';
    import type SelectInputOptionInterface from '../../components/elements/interface/select-input-option.interface';
    import SelectInput from '../../components/fields/SelectInput.vue';
    import TextArea from '../../components/fields/TextArea.vue'

    const isLoading = ref<boolean>(true)
    const campaignStore = useCampaignStore()
    const speciesStore = useSpeciesStore()
    const monster = defineModel<MonsterEntityInterface>('monster', { required: true })

    const props = defineProps<{
        isParentLoading: boolean
    }>()

    const sizeOptions: SelectInputOptionInterface[] = [
        { value: null, text: '-- Unknown size --' },
        { value: 20, text: 'Tiny' },
        { value: 30, text: 'Small' },
        { value: 40, text: 'Medium' },
        { value: 50, text: 'Large' },
        { value: 60, text: 'Huge' },
        { value: 70, text: 'Gargantuan' },
    ];

    const emit = defineEmits(['saveMonster'])
    function submitForm() {
        emit('saveMonster')
    }
</script>

<template>
    <loading-page :is-loading="props.isParentLoading">
        <template #content>
            <form @submit.prevent="submitForm" class="flex flex-col gap-6">
                <div class="">
                    <TextInput inputName="name" v-model:model="monster.name" label="Monster Name" :require="true">
                    </TextInput>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 w-full gap-6">
                    <div class="">
                        <NumberInput inputName="default_hit_points" v-model:model="monster.default_hit_points"
                            label="Default hit points">
                        </NumberInput>
                    </div>
                    <div class="">
                        <NumberInput inputName="calculated_hit_points_dice_count"
                            v-model:model="monster.calculated_hit_points_dice_count" label="Dice count"></NumberInput>
                    </div>
                    <div class="">
                        <NumberInput inputName="calculated_hit_points_dice_type"
                            v-model:model="monster.calculated_hit_points_dice_type" label="Dice type">
                        </NumberInput>
                    </div>
                    <div class="">
                        <NumberInput inputName="calculated_hit_points_modifier"
                            v-model:model="monster.calculated_hit_points_modifier" label="Modifier"></NumberInput>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 w-full gap-6">
                    <div class="">
                        <NumberInput inputName="armour_class" v-model:model="monster.armour_class"
                            label="Armour class (AC)">
                        </NumberInput>
                    </div>
                    <div class="">
                        <NumberInput inputName="speed" v-model:model="monster.speed" label="Speed"></NumberInput>
                    </div>
                    <div class="">
                        <NumberInput inputName="challenge_rating" v-model:model="monster.challenge_rating"
                            label="Challenge rating (CR)">
                        </NumberInput>
                    </div>
                    <div class="">
                        <SelectInput inputName="size" v-model:model="monster.size" label="Size" :options="sizeOptions">
                        </SelectInput>
                    </div>
                </div>
                <div class="w-full">
                    <TextArea inputName="description" v-model:model="monster.description"
                        label="Description"></TextArea>
                </div>
                <div class="w-full">
                </div>
                <EntityButtonWrapper :cancelDestination="{ name: 'monsters.list' }"></EntityButtonWrapper>
            </form>
        </template>
        <template #loading-text>monster</template>
    </loading-page>
</template>
