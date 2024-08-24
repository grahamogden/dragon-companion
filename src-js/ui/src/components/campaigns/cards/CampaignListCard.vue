<script setup lang="ts">
  import { useCampaignStore } from '../../../stores/campaign'
  import { useNotificationStore } from '../../../stores/notifications/notification-store'
  import type { CampaignEntityInterface } from '../../../services/campaign';
  import ImageCard from '../../cards/ImageCard.vue'
  import { DropDownItemButton, DropDownItemRouter } from '../../interfaces/drop-down.item.interface';
  import KebabMenu from '../../dropdowns/kebab-menu/KebabMenu.vue';
  import KebabMenuItemButton from '../../dropdowns/kebab-menu/KebabMenuItemButton.vue';
  import KebabMenuItemText from '../../dropdowns/kebab-menu/KebabMenuItemText.vue';
  import KebabMenuItemLink from '../../dropdowns/kebab-menu/KebabMenuItemLink.vue';

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
</script>
<template>
  <image-card :text="props.campaign.name" :is-selected="props.campaign.id === campaignStore.selectedCampaignId">
    <div class="flex items-center w-full justify-between">
      <p class="truncate text-ellipsis overflow-hidden">{{ props.campaign.name }}</p>
      <div>
        <KebabMenu :button-aria-context-name="'Campaign ' + props.campaign.name">
          <template #items>
            <KebabMenuItemText v-if="props.campaign.id === campaignStore.selectedCampaignId" :args="[campaign.id]">
              <font-awesome-icon :icon="['fas', 'ban']" fixed-width class="mr-2"></font-awesome-icon>Selected
            </KebabMenuItemText>
            <KebabMenuItemButton v-else :func="changeCampaign" :args="[campaign.id]">
              <font-awesome-icon :icon="['fas', 'check']" fixed-width class="mr-2"></font-awesome-icon>Select
            </KebabMenuItemButton>
            <KebabMenuItemLink :destination="{ name: 'campaigns.edit', params: { externalCampaignId: campaign.id } }">
              <font-awesome-icon :icon="['fas', 'pencil']" fixed-width class="mr-2"></font-awesome-icon>Edit
            </KebabMenuItemLink>
            <KebabMenuItemButton :func="confirmDelete" :args="[campaign.id]" :is-destructive="true">
              <font-awesome-icon :icon="['fas', 'trash']" fixed-width class="mr-2"></font-awesome-icon>Delete
            </KebabMenuItemButton>
          </template>
        </KebabMenu>
      </div>
    </div>
  </image-card>
</template>