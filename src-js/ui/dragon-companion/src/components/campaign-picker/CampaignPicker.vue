<script setup lang="ts">
  import { ref } from 'vue'
  import router from '../../router'
  import { useCampaignStore, useUserAuthStore } from '../../stores';

  const campaignStore = useCampaignStore()
  const userAuthStore = useUserAuthStore()

  const selectedCampaignId = ref<number>(0);
  selectedCampaignId.value = campaignStore.selectedCampaignId ? campaignStore.selectedCampaignId : 0

  function changeCampaign() {
    campaignStore.selectCampaign(selectedCampaignId.value !== 0 ? selectedCampaignId.value : null)
    const routeName = router.currentRoute.value.name !== null ? router.currentRoute.value.name : undefined;
    if (routeName) {
      router.push({ name: routeName, params: { externalCampaignId: campaignStore.campaignId }})
    }
  }

  userAuthStore.$subscribe(
    (mutation, state) => {
      if(state.user !== null) {
        console.debug('Auth changed - update campaigns in CampaignPicker')
        campaignStore.fetchCampaigns()
      } else {
        console.debug('No user found')
      }
    }
  )
</script>

<template>
  <div class="campaign-picker flex flex-col md:flex-row md:items-center md:gap-x-4 text-parchment-pale p-2 md:p-0 text-center" v-if="userAuthStore.isLoggedIn">
    <p>Pick a campaign:</p>
    <div>
      <select v-model.number="selectedCampaignId" @change="changeCampaign" class="w-full md:w-auto md:min-w-56 border border-parchment-pale roundness-2 text-base">
        <option value="0">Please select</option>
        <option v-for="campaign in campaignStore.campaigns" :value="campaign.id">{{ campaign.name }}</option>
      </select>
    </div>
  </div>
</template>