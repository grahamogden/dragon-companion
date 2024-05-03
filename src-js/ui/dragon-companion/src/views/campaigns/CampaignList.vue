<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { useCampaignStore } from '../../stores/campaign'
import KebabMenu from '../../components/kebab-menu/KebabMenu.vue'
import { type LinkInterface, LinkInterfaceTypeEnum } from '../../components/interfaces/link-interface';
import type { CampaignEntityInterface } from '../../services/campaign';

const campaignStore = useCampaignStore()

function confirmDelete(campaignId: number) {
  console.debug('Confirming delete for ' + campaignId)
  if (window.confirm('Are you sure you want to delete ' + campaignId + ': "' + campaignStore.getCampaignById(campaignId)?.name + '"')) {
    console.debug('Confirmed - attempting delete')
    campaignStore.deleteCampaign(campaignId)
  }
}

function getLinks(campaign: CampaignEntityInterface): LinkInterface[] {
  return [
    {
      label: 'Edit',
      type: LinkInterfaceTypeEnum.ROUTER,
      destination: {name: 'campaigns.edit', params: { externalCampaignId: campaign.id }},
    },
    {
      label: 'Delete',
      type: LinkInterfaceTypeEnum.BUTTON,
      function: {
        func: confirmDelete,
        args: [campaign.id],
      }
    }
  ]
}
</script>

<template>
  <h1>Campaigns</h1>
  <div class="mb-4">
    <router-link :to="{ name: 'campaigns.add' }" class="primary-button">Add campaign</router-link>
  </div>
  <div>
    <table class="entity-list-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Synopsis</th>
          <th aria-label="Actions"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="campaign in campaignStore.campaigns">
          <td><router-link :to="{ name: 'campaigns.view', params: { externalCampaignId: campaign.id }}">{{ campaign.name }}</router-link></td>
          <td>{{ campaign.synopsis }}</td>
          <td class="action-cell w-fit">
            <KebabMenu :links="getLinks(campaign)" :context-name="'Campaign ' + campaign.name" />
            <!-- <div> -->
              <!-- <router-link :to="{ name: 'campaigns.edit', params: { externalCampaignId: campaign.id }}">Edit</router-link> -->
            <!-- </div> -->
            <!-- <div> -->
              <!-- <button class="destructive-button" @click="confirmDelete(campaign.id!)">Delete</button> -->
            <!-- </div> -->
          </td>
        </tr>
      </tbody>
    </table>
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