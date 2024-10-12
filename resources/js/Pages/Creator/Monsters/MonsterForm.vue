<script setup lang="ts">
    import EntityButtonWrapper from '../../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
    import SelectInput from '../../../Components/Fields/SelectInput.vue';
    import TextArea from '../../../Components/Fields/TextArea.vue'
    import BaseInput from '../../../Components/Fields/BaseInput.vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
    import { useCampaignStore } from '../../../stores';
    import { PropType } from 'vue';
    import { MonsterEntityInterface, MonsterSizeEnum } from '../../../types/entities/monster/';
    import { CollectionInterface } from '../../../types/resource';
    import { SelectInputOptionInterface } from '../../../types/entity-option';
    import { ChallengeRatingEnum } from '../../../types/entities/monster/challenge-rating.enum';
    import { EnumUtils } from '../../../types/enum.utils';
    import PageHeader from '../../../Components/page-header/PageHeader.vue';

    const props = defineProps({
        monster: { type: Object as PropType<MonsterEntityInterface>, required: false },
        species: { type: Object as PropType<CollectionInterface<SelectInputOptionInterface>>, required: true }
    })

    const campaignStore = useCampaignStore()

    const form = useForm({
        name: props.monster?.name ?? '',
        description: props.monster?.description ?? '',
        size: props.monster?.size ?? MonsterSizeEnum.Unknown,
        default_hit_points: props.monster?.default_hit_points ?? 0,
        calculated_hit_points_dice_count: props.monster?.calculated_hit_points_dice_count ?? 0,
        calculated_hit_points_dice_type: props.monster?.calculated_hit_points_dice_type ?? 0,
        calculated_hit_points_modifier: props.monster?.calculated_hit_points_modifier ?? 0,
        armour_class: props.monster?.armour_class ?? 0,
        speed: props.monster?.speed ?? 0,
        challenge_rating: props.monster?.challenge_rating ?? 0,
        species_id: props.monster?.species_id ?? null,
    })

    const saveMonster = () => {
        if (props.monster) {
            form.put(route('creator.campaigns.monsters.update', { campaign: campaignStore.selectedCampaignId, monster: props.monster.id }))
        } else {
            form.post(route('creator.campaigns.monsters.store', { campaign: campaignStore.selectedCampaignId }))
        }
    }

    const title = (props.monster ? 'Edit ' + props.monster.name : 'Create a') + ' Monster'
</script>

<template>

    <Head :title="title" />
    <form @submit.prevent="saveMonster">
        <CreatorDefaultContentLayout>
            <PageHeader><template #title>{{ title }}</template></PageHeader>
            <div class="">
                <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name"
                    label="Monster Name" :require="true">
                </BaseInput>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 2xl:grid-cols-8 w-full gap-default md:gap-default-md">
                <div class="">
                    <BaseInput type="number" inputName="default_hit_points" v-model:model="form.default_hit_points"
                        :error="form.errors.default_hit_points" label="Default hit points">
                    </BaseInput>
                </div>
                <div class="">
                    <BaseInput type="number" inputName="calculated_hit_points_dice_count"
                        v-model:model="form.calculated_hit_points_dice_count"
                        :error="form.errors.calculated_hit_points_dice_count" label="Dice count"></BaseInput>
                </div>
                <div class="">
                    <BaseInput type="number" inputName="calculated_hit_points_dice_type"
                        v-model:model="form.calculated_hit_points_dice_type"
                        :error="form.errors.calculated_hit_points_dice_type" label="Dice type">
                    </BaseInput>
                </div>
                <div class="">
                    <BaseInput type="number" inputName="calculated_hit_points_modifier"
                        v-model:model="form.calculated_hit_points_modifier"
                        :error="form.errors.calculated_hit_points_modifier" label="Modifier"></BaseInput>
                </div>
                <div class="">
                    <BaseInput type="number" inputName="armour_class" v-model:model="form.armour_class"
                        :error="form.errors.armour_class" label="Armour class (AC)">
                    </BaseInput>
                </div>
                <div class="">
                    <BaseInput type="number" inputName="speed" v-model:model="form.speed" :error="form.errors.speed"
                        label="Speed">
                    </BaseInput>
                </div>
                <div class="">
                    <SelectInput inputName="challenge_rating" v-model:model="form.challenge_rating"
                        :error="form.errors.challenge_rating" label="Challenge rating (CR)"
                        :options="EnumUtils.getSelectOptions(ChallengeRatingEnum)">
                    </SelectInput>
                </div>
                <div class="">
                    <SelectInput inputName="size" v-model:model="form.size" :error="form.errors.size" label="Size"
                        :options="EnumUtils.getSelectOptions(MonsterSizeEnum)">
                    </SelectInput>
                </div>
            </div>
            <div class="w-full">
                <TextArea inputName="description" v-model:model="form.description" :error="form.errors.description"
                    label="Description"></TextArea>
            </div>
            <div class="w-full">
            </div>
            <EntityButtonWrapper
                :cancelDestination="route('creator.campaigns.monsters.index', { campaign: campaignStore.selectedCampaignId })">
            </EntityButtonWrapper>
        </CreatorDefaultContentLayout>
    </form>
</template>
