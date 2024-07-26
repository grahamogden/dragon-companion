<script setup lang="ts">
  import { ref } from 'vue';
  import { useCampaignStore } from '../../stores/campaign';
  import router from '../../router';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { storeToRefs } from 'pinia';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const params = router.currentRoute.value.params
  const campaignId = parseInt(params.externalCampaignId as string)
  let formData = ref({})

  const { getCampaignById } = storeToRefs(campaignStore)
  const campaign = getCampaignById.value(campaignId)
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
    <page-header link-text="Edit"
      :link-destination="{ name: 'campaigns.edit', params: { externalCampaignId: campaignId } }">{{ campaign?.name ??
        'Unknown' }}</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <div>
          {{ campaign?.synopsis }}
        </div>
      </template>
      <template #loading-text>campaign</template>
    </loading-page>
  </div>
</template>