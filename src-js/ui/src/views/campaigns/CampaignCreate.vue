<script setup lang="ts">
  import { useCampaignStore } from '../../stores/campaign';
  import router from '../../router';
  import CampaignForm from './CampaignForm.vue';
  import { type CampaignEntityInterface } from '../../services/campaign/CampaignEntityInterface';
  import PageHeader from '../../components/page-header/PageHeader.vue';

  const campaignStore = useCampaignStore()

  async function createCampaign(formData: CampaignEntityInterface): Promise<void> {
    await campaignStore.addCampaign(
      {
        name: formData.name,
        synopsis: formData.synopsis
      }
    )
    router.push({ name: 'campaigns.list' })
  }
</script>

<template>
  <div class="campaign-create">
    <page-header>Create a Campaign</page-header>
    <campaign-form @save-campaign="createCampaign"></campaign-form>
  </div>
</template>