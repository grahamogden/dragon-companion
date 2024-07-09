<script setup lang="ts">
  import { reactive, ref } from 'vue';
  import { useCampaignStore } from '../../stores/campaign';
  import router from '../../router';
  import EntityPage from '../../components/entity-page/EntityPage.vue';
  import PageHeader from '../../components/page-header/PageHeader.vue';
import { storeToRefs } from 'pinia';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const params = router.currentRoute.value.params
  // console.debug(router.currentRoute.value)
  // console.debug(router.currentRoute.value.params)
  const campaignId = parseInt(params.externalCampaignId as string)
  let formData = ref({})

  const { getCampaignById } = storeToRefs(campaignStore)
  const campaign = getCampaignById.value(campaignId)
  // console.dir(campaignId)
  // console.dir(campaign)
  if (campaign !== undefined) {
    formData = ref({
      name: campaign.name,
      synopsis: campaign.synopsis
    })
    isLoading.value = false
  }
</script>

<template>
  <div class="campaign-view">
    <page-header link-text="Edit" :link-destination="{ name: 'campaigns.edit', params: {externalCampaignId: campaignId} }">{{ campaign?.name ?? 'Unknown' }}</page-header>
    <entity-page v-model="isLoading">
      <template #content>
        <div>
          {{ campaign?.synopsis }}
        </div>
      </template>
      <template #loading-text>campaign</template>
    </entity-page>
  </div>
</template>