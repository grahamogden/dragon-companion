<script setup lang="ts">
  import { ref } from 'vue';
  import { useCampaignStore } from '../../stores/campaign';
  import router from '../../router';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { storeToRefs } from 'pinia';
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../components/page-header/interface';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const params = router.currentRoute.value.params
  const campaignId = parseInt(params.externalCampaignId as string)

  const { getCampaignById } = storeToRefs(campaignStore)
  const campaign = getCampaignById.value(campaignId)
  if (campaign !== undefined) {
    isLoading.value = false
  }
</script>

<template>
  <div class="campaign-view">
    <page-header
      :link="new PageHeaderLink('Edit', { name: 'campaigns.edit', params: { externalCampaignId: campaignId } }, PageHeaderLinkActionEnum.EDIT)">{{
        campaign?.name ??
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