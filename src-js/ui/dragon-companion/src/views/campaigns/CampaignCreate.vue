<script setup lang="ts">
import { useCampaignStore } from '../../stores/campaign';
import router from '../../router';
import CampaignForm from './CampaignForm.vue';
import type CampaignEntityInterface from '../../services/campaign/CampaignEntityInterface';

const campaignStore = useCampaignStore()

async function createCampaign(formData: CampaignEntityInterface): Promise<void> {
  await campaignStore.addCampaign(
    {
      name: formData.name,
      synopsis: formData.synopsis
    }
  )
  router.push({name: 'campaigns.list'})
}
</script>

<template>
  <div class="campaign-create">
    <h1>This is the campaigns page - where you can create your campaigns!</h1>
    <CampaignForm @save-campaign="createCampaign" />
  </div>
</template>