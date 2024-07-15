<script setup lang="ts">
  import { RouterLink } from 'vue-router'
  import { useCampaignStore } from '../../stores/campaign'
  import KebabMenu from '../../components/dropdowns/kebab-menu/KebabMenu.vue'
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue';
  import { DropDownItemRouter, DropDownItemButton } from '../../components/interfaces/drop-down.item.interface';
  import type { CampaignEntityInterface } from '../../services/campaign';
  // import router from '../../router'

  const campaignStore = useCampaignStore()
  campaignStore.getCampaigns()

  function changeCampaign(value: number) {
    campaignStore.selectCampaign(value)
  }

  function confirmDelete(campaignId: number) {
    console.debug('Confirming delete for ' + campaignId)
    if (window.confirm('Are you sure you want to delete ' + campaignId + ': "' + campaignStore.getCampaignById(campaignId)?.name + '"')) {
      console.debug('Confirmed - attempting delete')
      campaignStore.deleteCampaign(campaignId)
    }
  }

  function getLinks(campaign: CampaignEntityInterface): (DropDownItemRouter | DropDownItemButton)[] {
    return [
      new DropDownItemButton(
        'Select',
        {
          func: changeCampaign,
          args: [campaign.id],
        }
      ),
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
      ),
    ]
  }
</script>

<template>
  <page-header link-text="Add campaign" :link-destination="{ name: 'campaigns.add' }" >Campaigns</page-header>
  <loading-page>
    <template #content>
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
            </td>
          </tr>
        </tbody>
      </table>
    </template>
    <template #loading-text>campaigns</template>
  </loading-page>
</template>