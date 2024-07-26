<script setup lang="ts">
  import { ref } from 'vue'
  import { useCampaignStore } from '../../stores/campaign'
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue';
  import CampaignListCard from '../../components/campaigns/cards/CampaignListCard.vue';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  campaignStore.getCampaigns().finally(() => {
    isLoading.value = false
  })

</script>

<template>
  <page-header link-text="Add campaign" :link-destination="{ name: 'campaigns.add' }">Campaigns</page-header>
  <loading-page :is-loading="isLoading">
    <template #content>
      <div class="grid gap-4 xl:grid-cols-3 sm:grid-cols-2 grid-cols-1 grid-flow-row justify-between px-4">
        <campaign-list-card v-for="campaign in campaignStore.campaigns" :campaign="campaign"></campaign-list-card>
      </div>
    </template>
    <template #loading-text>campaigns</template>
  </loading-page>
</template>