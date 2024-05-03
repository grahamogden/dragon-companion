<script setup lang="ts">
  import { ref, reactive } from 'vue';
  import { useCampaignStore } from '../../stores/campaign';
  import router from '../../router';
  import CampaignForm from './CampaignForm.vue'
  import { type CampaignEntityInterface } from '../../services/campaign/CampaignEntityInterface';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const params = router.currentRoute.value.params
  console.debug(router.currentRoute.value)
  console.debug(router.currentRoute.value.params)
  const campaignId = parseInt(params.externalCampaignId as string)
  let formData = reactive({})

  console.debug(campaignId)
  const campaign = campaignStore.getCampaignById(campaignId)
  console.debug(campaign);
  if (campaign !== undefined) {
    formData = reactive({
      name: campaign.name,
      synopsis: campaign.synopsis
    })
  }

  async function editCampaign(formData: CampaignEntityInterface): Promise<void> {
    await campaignStore.updateCampaign(
      {
        id: campaignId,
        name: formData.name,
        synopsis: formData.synopsis
      }
    )
    console.debug('Editing campaign')
    router.push({ name: 'campaigns.list' })
  }
</script>

<template>
  <div class="campaign-edit" v-if="isLoading">
    <h1>{{ campaign?.name ?? 'Unknown' }}</h1>
    <div>
      {{ campaign?.synopsis }}
    </div>
  </div>
</template>