<script setup lang="ts">
    import TextInput from '../../components/fields/TextInput.vue'
    import TextArea from '../../components/fields/TextArea.vue'
    import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
    import type { CampaignEntityInterface, NewCampaignEntityInterface } from '../../services/campaign'
    import { CampaignEntity } from '../../services/campaign'
    import LoadingPage from '../../components/loading-page/LoadingPage.vue';

    const props = defineProps<{
        data?: CampaignEntityInterface
        isLoading?: boolean
    }>()

    let campaign: NewCampaignEntityInterface = new CampaignEntity(
        props.data?.id,
        props.data?.name,
        props.data?.synopsis
    );

    if (props.data) {
        campaign = props.data
    }

    const emit = defineEmits(['saveCampaign'])
    function submitForm() {
        emit('saveCampaign', campaign)
    }
</script>

<template>
    <loading-page :is-loading="props.isLoading">
        <template #content>
            <form @submit.prevent="submitForm" class="flex flex-row flex-wrap gap-6">
                <div class="w-full md:w-2/4">
                    <text-input inputName="name" v-model:model="campaign.name" label="Campaign Name"
                        :require="true"></text-input>
                </div>
                <div class="w-full">
                    <text-area inputName="synopsis" v-model:model="campaign.synopsis" label="Synopsis of campaign"
                        :length="1000" :require="true"></text-area>
                </div>
                <EntityButtonWrapper :cancelDestination="{ name: 'campaigns.list' }" />
            </form>
        </template>
        <template #loading-text>campaign</template>
    </loading-page>
</template>
