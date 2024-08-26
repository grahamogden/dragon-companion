<script setup lang="ts">
  import { ref } from 'vue'
  import { useCampaignStore } from '../../stores/campaign'
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue';
  import CampaignListCard from '../../components/campaigns/cards/CampaignListCard.vue';
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../components/page-header/interface';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  campaignStore.getCampaigns().finally(() => {
    isLoading.value = false
  })

</script>

<template>
  <page-header
    :link="new PageHeaderLink('Add campaign', { name: 'campaigns.add' }, PageHeaderLinkActionEnum.ADD)">Campaigns</page-header>
  <loading-page :is-loading="isLoading">
    <template #content>
      <div
        class="grid gap-default md:gap-default-md grid-cols-1 xs:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 grid-flow-row justify-between justify-items-stretch">
        <campaign-list-card v-for="campaign in campaignStore.campaigns" :campaign="campaign"></campaign-list-card>
      </div>
    </template>
    <template #loading-text>campaigns</template>
  </loading-page>
</template>