<script setup lang="ts">
    import TextInput from '../../Components/fields/TextInput.vue'
    import NumberInput from '../../Components/fields/NumberInput.vue'
    import EntityButtonWrapper from '../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
    import { type MonsterEntityInterface } from '../../services/monster'
    import LoadingPage from '../../Components/loading-page/LoadingPage.vue';
    import type SelectInputOptionInterface from '../../Components/elements/interface/select-input-option.interface';
    import SelectInput from '../../Components/fields/SelectInput.vue';
    import TextArea from '../../Components/fields/TextArea.vue'
    import BaseInput from '../../Components/fields/BaseInput.vue';

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
</script>

<template>
    <LoadingPage :is-loading="props.isParentLoading">
        <template #content>
            <form @submit.prevent="submitForm" class="flex flex-col gap-default md:gap-default-md">
                <div class="">
                    <BaseInput type="text" inputName="name" v-model:model="monster.name" label="Monster Name"
                        :require="true">
                    </BaseInput>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 2xl:grid-cols-8 w-full gap-default md:gap-default-md">
                    <div class="">
                        <BaseInput type="number" inputName="default_hit_points"
                            v-model:model="monster.default_hit_points" label="Default hit points">
                        </BaseInput>
                    </div>
                    <div class="">
                        <BaseInput type="number" inputName="calculated_hit_points_dice_count"
                            v-model:model="monster.calculated_hit_points_dice_count" label="Dice count"></BaseInput>
                    </div>
                    <div class="">
                        <BaseInput type="number" inputName="calculated_hit_points_dice_type"
                            v-model:model="monster.calculated_hit_points_dice_type" label="Dice type">
                        </BaseInput>
                    </div>
                    <div class="">
                        <BaseInput type="number" inputName="calculated_hit_points_modifier"
                            v-model:model="monster.calculated_hit_points_modifier" label="Modifier"></BaseInput>
                    </div>
                    <div class="">
                        <BaseInput type="number" inputName="armour_class" v-model:model="monster.armour_class"
                            label="Armour class (AC)">
                        </BaseInput>
                    </div>
                    <div class="">
                        <BaseInput type="number" inputName="speed" v-model:model="monster.speed" label="Speed">
                        </BaseInput>
                    </div>
                    <div class="">
                        <BaseInput type="number" inputName="challenge_rating" v-model:model="monster.challenge_rating"
                            label="Challenge rating (CR)">
                        </BaseInput>
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
    </LoadingPage>
</template>
