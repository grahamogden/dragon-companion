<script setup lang="ts">
import TextInput from '../../components/elements/TextInput.vue'
import TextArea from '../../components/elements/TextArea.vue'
import EntityButtonWrapper from '../../components/entity-button-wrapper/EntityButtonWrapper.vue'
import type { CampaignEntityInterface, NewCampaignEntityInterface } from '../../services/campaign'
import { CampaignEntity } from '../../services/campaign'

const emit = defineEmits(['saveCampaign'])
const props = defineProps<{
    data?: CampaignEntityInterface
}>()

let formData: NewCampaignEntityInterface = new CampaignEntity(
    props.data?.id,
    props.data?.name,
    props.data?.synopsis
);

if (props.data) {
    formData = props.data
}

function submitForm() {
    emit('saveCampaign', formData)
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <pre class="hidden">
name: {{ formData.name }}
synopsis: {{ formData.synopsis }}
        </pre>
        <!-- <TextInput inputName="name" :inputValue="props.data?.name" label="Campaign Name" @update-value="updateValue" /> -->
        <div class="w-full md:w-2/4">
            <TextInput inputName="name" v-model="formData.name" label="Campaign Name" />
        </div>
        <!-- <TextInput inputName="synopsis" :inputValue="props.data?.synopsis" label="Synopsis of campaign" @update-value="updateValue" /> -->
        <TextArea inputName="synopsis" v-model="formData.synopsis" label="Synopsis of campaign" :length="1000" />
        <!-- <div class="mt-10"> -->
            <!-- <PrimaryButton text="Save" /> -->
            <!-- <LinkButton text="Cancel" :destination="{ name: 'campaigns.list' }" /> -->
            <!-- <button class="primary-button my-2" type="submit">Save</button> -->
            <!-- <router-link :to="{ name: 'campaigns.list' }" class="secondary-button my-4" >Cancel</router-link> -->
        <!-- </div> -->
        <EntityButtonWrapper :cancelDestination="{ name: 'campaigns.list'}" />
    </form>
</template>
