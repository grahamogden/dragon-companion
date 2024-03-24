<script setup lang="ts">
import { inject, defineModel, getCurrentInstance } from 'vue'
import { getAuth, onAuthStateChanged } from 'firebase/auth'
import { firebaseAppKey } from '../../keys'
import type { FirebaseApp } from 'firebase/app'
import { useCampaignStore } from '../../stores/campaign';
import router from '../../router'

const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
const campaignStore = useCampaignStore()

const selectedCampaign = defineModel<number|null>({default: null})
selectedCampaign.value = campaignStore.selectedCampaignId

function changeCampaign() {
  campaignStore.selectCampaign(selectedCampaign.value)
  const routeName = router.currentRoute.value.name !== null ? router.currentRoute.value.name : undefined;
  console.debug(routeName)
  if (routeName) {
    router.push({ name: routeName, params: { externalCampaignId: campaignStore.campaignId }})
  }
}

const auth = getAuth(firebaseApp)
onAuthStateChanged(
  auth,
  (user) => {
    if(user !== null) {
          console.debug('Auth changed - update campaigns in CampaignPicker')
          campaignStore.fetchCampaigns()
    } else {
      console.debug('No user found')
    }
  }
)
</script>

<template>
  <div class="campaign-list">
    <p>Pick a campaign</p>
    <div>
      <select v-model.number="selectedCampaign" @change="changeCampaign()">
        <option value="" disabled>Please select</option>
        <option v-for="campaign in campaignStore.campaigns" :value="campaign.id">{{ campaign.name }}</option>
      </select>
    </div>
    <p>Selected campaign: {{ campaignStore.campaignId }} - {{ campaignStore.campaignName }}</p>
  </div>
</template>

<style scoped>
@media (min-width: 1024px) {
  .campaign-list {
    min-height: 100vh;
    display: flex;
    /* align-items: center; */
  }
}
</style>
