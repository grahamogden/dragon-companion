<script setup lang="ts">
  import { RouterLink } from 'vue-router'
  import { useCampaignStore } from '../../stores/campaign'
  import KebabMenu from '../../components/dropdowns/kebab-menu/KebabMenu.vue'
  import { DropDownItemRouter, DropDownItemButton } from '../../components/interfaces/drop-down.item.interface';
  import type { CampaignEntityInterface } from '../../services/campaign';

  const campaignStore = useCampaignStore()

  function confirmDelete(campaignId: number) {
    console.debug('Confirming delete for ' + campaignId)
    if (window.confirm('Are you sure you want to delete ' + campaignId + ': "' + campaignStore.getCampaignById(campaignId)?.name + '"')) {
      console.debug('Confirmed - attempting delete')
      campaignStore.deleteCampaign(campaignId)
    }
  }

  function getLinks(campaign: CampaignEntityInterface): (DropDownItemRouter | DropDownItemButton)[] {
    return [
      new DropDownItemRouter(
        'Edit',
        { name: 'campaigns.edit', params: { externalCampaignId: campaign.id } },
      ),
      new DropDownItemButton(
        'Delete',
        {
          func: confirmDelete,
          args: [campaign.id],
        }
      )
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
          <td><router-link :to="{ name: 'campaigns.view', params: { externalCampaignId: campaign.id } }">{{ campaign.name
              }}</router-link></td>
          <td>{{ campaign.synopsis }}</td>
          <td class="action-cell w-fit">
            <KebabMenu :links="getLinks(campaign)" :button-aria-context-name="'Campaign ' + campaign.name" />
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