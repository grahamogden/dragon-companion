<script setup lang="ts">
  import { ref, reactive } from 'vue';
  import { useCampaignStore } from '../../stores/campaign';
  import router from '../../router';
  import CampaignForm from './CampaignForm.vue'
  import { type CampaignEntityInterface } from '../../services/campaign/CampaignEntityInterface';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import EntityPage from '../../components/entity-page/EntityPage.vue';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const params = router.currentRoute.value.params
  // console.debug(router.currentRoute.value)
  // console.debug(router.currentRoute.value.params)
  const campaignId = parseInt(params.externalCampaignId as string)
  let formData: CampaignEntityInterface | undefined = undefined

  // console.debug(campaignId)
  const campaign = campaignStore.getCampaignById(campaignId)
  // console.debug(campaign);
  if (campaign !== undefined) {
    formData = reactive(campaign)
    isLoading.value = false
  }

  async function editCampaign(formData: CampaignEntityInterface): Promise<void> {
    await campaignStore.updateCampaign(
      {
        id: campaignId,
        name: formData.name,
        synopsis: formData.synopsis
      }
    )
    // console.debug('Editing campaign')
    router.push({ name: 'campaigns.list' })
  }
</script>

<template>
  <div class="campaign-edit">
    <!-- <div class="flex flex-row justify-between items-center mb-4">
      <h1>Editing - {{ campaign?.name ?? 'Unknown' }}</h1>
    </div> -->
    <page-header>{{ campaign?.name ?? 'Unknown' }}</page-header>
    <entity-page v-model="isLoading">
      <template #content>
        <CampaignForm :data="formData" @save-campaign="editCampaign" />
      </template>
      <template #loading-text>campaign</template>
    </entity-page>
  </div>
</template>