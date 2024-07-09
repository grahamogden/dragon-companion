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
      router.push({ name: routeName, params: { externalCampaignId: campaignStore.campaignId } })
    }
  }

  userAuthStore.$subscribe(
    (mutation, state) => {
      if (state.user !== null) {
        console.debug('Auth changed - update campaigns in CampaignPicker')
        campaignStore.getCampaigns()
      } else {
        console.debug('No user found')
      }
    }
  )
</script>

<template>
  <div class="campaign-picker bg-horizon-light bg-contain h-36 w-full flex flex-col justify-end"
    v-if="userAuthStore.isLoggedIn">
    <!-- <img class="w-8 mx-6" src="@/assets/images/dice-icon.svg" /> -->
    <!-- <label for="selected-campaign">Selected Campaign:</label> -->
    <div class="table grow">
      <router-link class="table-cell align-middle text-white-lilac-50 bg-shark-950/75 backdrop-blur-sm no-underline hover:underline text-center duration-200" :class="{ 'opacity-0': campaignStore.isCampaignSelected }"
        v-if="userAuthStore.isLoggedIn" :to="{ name: 'campaigns.list' }">Go To Your Campaigns</router-link>
    </div>
    <div class="px-2 bg-timberwolf-50/90 dark:bg-woodsmoke-950/90 backdrop-blur-sm duration-500 italic">
      <select id="selected-campaign" v-model.number="selectedCampaignId" @change="changeCampaign"
        class="w-full min-w-56 text-base py-2 bg-transparent duration-500"
        aria-label="Change currently selected campaign">
        <option value="0">Please select</option>
        <option v-for="campaign in campaignStore.campaigns" :value="campaign.id">{{ campaign.name }}</option>
      </select>
    </div>
  </div>
</template>