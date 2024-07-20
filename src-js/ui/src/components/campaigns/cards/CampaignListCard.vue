<script setup lang="ts">
  import { useCampaignStore } from '../../../stores/campaign'
  import { useNotificationStore } from '../../../stores/notifications/notification-store'
  import type { CampaignEntityInterface } from '../../../services/campaign';
  import ImageCard from '../../cards/ImageCard.vue'
  import { DropDownItemButton, DropDownItemRouter } from '../../interfaces/drop-down.item.interface';
  import KebabMenu from '../../dropdowns/kebab-menu/KebabMenu.vue';
  import { NotificationEnum } from '../../../stores/notifications'

  const props = defineProps<{
    campaign: CampaignEntityInterface,
  }>()

  const campaignStore = useCampaignStore()
  const notificationStore = useNotificationStore()
  // campaignStore.getCampaigns()

  function changeCampaign(value: number) {
    notificationStore.removeAllNotifications()
    campaignStore.selectCampaign(value)
    notificationStore.addSuccess('Campaign ' + campaignStore.campaignName + ' successfully selected')
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
  <image-card :text="props.campaign.name" :is-selected="props.campaign.id === campaignStore.selectedCampaignId">
    <p class="flex flex-col justify-center">{{ props.campaign.name }}</p>
    <kebab-menu :links="getLinks(props.campaign)" :button-aria-context-name="'Campaign ' + props.campaign.name" />
  </image-card>
</template>