<script setup lang="ts">
  import { ref } from 'vue'
  import router from '../../router'
  import { useCampaignStore, useUserAuthStore } from '../../stores';

  const campaignStore = useCampaignStore()
  const userAuthStore = useUserAuthStore()

  const selectedCampaignId = ref<number>(0);
  selectedCampaignId.value = campaignStore.selectedCampaignId ? campaignStore.selectedCampaignId : 0

  // function changeCampaign(value: number) {
  //   if (value === 0 || value === null) {
  //     console.debug('Campaign unselected, redirecting to campaigns.list')
  //     router.push({ name: 'campaigns.list' })
  //     campaignStore.selectCampaign(null)
  //     return
  //   }

  //   campaignStore.selectCampaign(value)
  //   const routeName = router.currentRoute.value.name !== null ? router.currentRoute.value.name : undefined;
  //   router.push({
  //     name: routeName,
  //     params: { externalCampaignId: campaignStore.campaignId }
  //   })
  // }

  // userAuthStore.$subscribe(
  //   (mutation, state) => {
  //     if (state.user !== null) {
  //       console.debug('Auth changed - update campaigns in CampaignPicker')
  //       campaignStore.getCampaigns()
  //     } else {
  //       console.debug('No user found')
  //     }
  //   }
  // )
</script>

<template>
  <div class="campaign-picker relative bg-horizon-light bg-cover bg-center h-36 w-full flex flex-col justify-end"
    v-if="userAuthStore.isLoggedIn">
    <!-- <img class="w-8 mx-6" src="@/assets/images/dice-icon.svg" /> -->
    <!-- <label for="selected-campaign">Selected Campaign:</label> -->
    <div v-if="campaignStore.isCampaignSelected"
      class="px-4 py-2 bg-timberwolf-50/90 dark:bg-woodsmoke-950/90 backdrop-blur-sm duration-theme-change">
      <!-- <select id="selected-campaign" @change="changeCampaign(parseInt($event.target!.value))"
        class="w-full min-w-56 text-base py-2 bg-transparent duration-theme-change"
        aria-label="Change currently selected campaign">
        <option value="0">Please select</option>
        <option v-for="campaign in campaignStore.campaigns" :value="campaign.id" :selected="selectedCampaignId === campaign.id">{{ campaign.name }}</option>
      </select> -->
      {{ campaignStore.campaignName }}
    </div>
    <div class="table absolute top-0 left-0 w-full h-full">
      <router-link
        class="table-cell align-middle text-white-lilac-50 bg-shark-950/75 backdrop-blur-sm no-underline hover:underline text-center transition-opacity duration-150"
        :class="{ 'opacity-0': campaignStore.isCampaignSelected }" v-if="userAuthStore.isLoggedIn"
        :to="{ name: 'campaigns.list' }">Go To Your Campaigns</router-link>
    </div>
  </div>
</template>