<script setup lang="ts">
import { RouterView, RouterLink } from 'vue-router'
import { useCampaignStore } from '../../stores/campaign';

const campaignStore = useCampaignStore()

function confirmDelete(campaignId: number) {
  console.debug('Confirming delete for ' + campaignId)
  if (window.confirm('Are you sure you want to delete ' + campaignId)) {
    console.debug('Confirmed - attempting delete')
    campaignStore.deleteCampaign(campaignId)
  }
}
</script>

<template>
  <div class="campaign-list">
    <h1>Campaigns</h1>
    <div>
      <router-link :to="{ name: 'campaigns.add' }">Add a new campaign!</router-link>
    </div>
    <div>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Synopsis</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="campaign in campaignStore.campaigns">
            <td>{{ campaign.name }}</td>
            <td>{{ campaign.synopsis }}</td>
            <td>
              <router-link :to="{ name: 'campaigns.edit', params: { externalCampaignId: campaign.id }}">Edit</router-link>
              <button class="" @click="confirmDelete(campaign.id!)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <router-view />
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