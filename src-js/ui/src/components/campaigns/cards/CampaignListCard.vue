<script setup lang="ts">
  import { useCampaignStore } from '../../../stores/campaign'
  import { useNotificationStore } from '../../../stores/notifications/notification-store'
  import type { CampaignEntityInterface } from '../../../services/campaign';
  import ImageCard from '../../cards/ImageCard.vue'
  import { DropDownItemButton, DropDownItemRouter } from '../../interfaces/drop-down.item.interface';
  import KebabMenu from '../../dropdowns/kebab-menu/KebabMenu.vue';

  const props = defineProps<{
    campaign: CampaignEntityInterface,
  }>()

  const campaignStore = useCampaignStore()
  const notificationStore = useNotificationStore()

  function changeCampaign(value: number) {
    notificationStore.removeAllNotifications()
    setTimeout(() => {
      campaignStore.selectCampaign(value)
      notificationStore.addSuccess('Campaign ' + campaignStore.campaignName + ' successfully selected')
    }, 250)
  }

  function confirmDelete(campaignId: number) {
    console.debug('Confirming delete for ' + campaignId)
    if (window.confirm('Are you sure you want to delete ' + campaignId + ': "' + campaignStore.getCampaignById(campaignId)?.name + '"')) {
      notificationStore.removeAllNotifications()
      console.debug('Confirmed - attempting delete')
      campaignStore.deleteCampaign(campaignId)
        .then(() => {
          notificationStore.addSuccess('Successfully deleted campaign')
        })
    }
  }

  function getLinks(campaign: CampaignEntityInterface): (DropDownItemRouter | DropDownItemButton)[] {
    const links = [];
    if (props.campaign.id !== campaignStore.selectedCampaignId) {
      links.push(new DropDownItemButton(
        'Select',
        {
          func: changeCampaign,
          args: [campaign.id],
        }
      ))
    }

    return [
      ...links,
      new DropDownItemRouter(
        'Edit',
        { name: 'campaigns.edit', params: { externalCampaignId: campaign.id } },
      ),
      new DropDownItemButton(
        'Delete',
        {
          func: confirmDelete,
          args: [campaign.id],
        },
        true
      ),
    ]
  }
</script>
<template>
  <image-card :text="props.campaign.name" :is-selected="props.campaign.id === campaignStore.selectedCampaignId">
    <div class="flex items-center w-full justify-between">
      <p class="truncate text-ellipsis overflow-hidden">{{ props.campaign.name }}</p>
      <div><kebab-menu :links="getLinks(props.campaign)"
          :button-aria-context-name="'Campaign ' + props.campaign.name" />
      </div>
    </div>
  </image-card>
</template>