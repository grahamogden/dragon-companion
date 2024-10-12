<script setup lang="ts">
  import { useCampaignStore } from '../../../stores/campaign'
  import { useNotificationStore } from '../../../stores/notifications/notification-store'
  import type { CampaignEntity, CampaignEntityInterface } from '../../../types/entities/campaign';
  import ImageCard from '../../cards/ImageCard.vue'
  import KebabMenuItemButton from '../../menu/wrapped-kebab-menu/KebabMenuItemButton.vue';
  import KebabMenuItemLink from '../../menu/wrapped-kebab-menu/KebabMenuItemLink.vue';
  import DropDownMenu from '../../drop-down/DropDownMenu.vue';
  import DropDownKebabIcon from '../../drop-down/DropDownKebabIcon.vue';
  import { PropType } from 'vue';
  import { router } from '@inertiajs/vue3';

  defineProps({
    campaign: { type: Object as PropType<CampaignEntityInterface>, required: true },
  })

  const campaignStore = useCampaignStore()
  const notificationStore = useNotificationStore()

  function changeCampaign(id: number, name: string) {
    notificationStore.removeAllNotifications()
    setTimeout(() => {
      campaignStore.selectCampaign(id, name)
      if (id === null) {
        notificationStore.addSuccess('Campaign unselected')
      } else {
        notificationStore.addSuccess('Campaign "' + campaignStore.campaignName + '" successfully selected')
      }
    }, 250)
  }

  const deleteCampaign = (campaign: CampaignEntity) => {
    console.debug('Confirming delete for ' + campaign.name)
    if (window.confirm('Are you sure you want to delete ' + campaign.name)) {
      console.debug('Confirmed - attempting delete')
      router.delete(route('creator.campaigns.destroy', { campaign: campaign.id }))
    }
  }
</script>
<template>
  <image-card :text="campaign.name" :is-selected="campaign.id === campaignStore.selectedCampaignId">
    <div class="flex items-center w-full justify-between">
      <p class="truncate text-ellipsis overflow-hidden">{{ campaign.name }}</p>
      <div>
        <DropDownMenu :button-aria-context-name="'Campaign ' + campaign.name">
          <template #button-content>
            <DropDownKebabIcon></DropDownKebabIcon>
          </template>
          <template #items>
            <!-- <KebabMenuItemText v-if="campaign.id === campaignStore.selectedCampaignId">
              <font-awesome-icon :icon="['fas', 'ban']" fixed-width class="mr-2"></font-awesome-icon>Currently selected
            </KebabMenuItemText> -->
            <KebabMenuItemButton v-if="campaign.id === campaignStore.selectedCampaignId" :func="changeCampaign"
              :args="[null, null]">
              <font-awesome-icon :icon="['fas', 'ban']" fixed-width class="mr-2"></font-awesome-icon>Currently selected
            </KebabMenuItemButton>
            <KebabMenuItemButton v-else :func="changeCampaign" :args="[campaign.id, campaign.name]">
              <font-awesome-icon :icon="['fas', 'check']" fixed-width class="mr-2"></font-awesome-icon>Select
            </KebabMenuItemButton>
            <KebabMenuItemLink :href="route('creator.campaigns.edit', { campaign: campaign.id })">
              <font-awesome-icon :icon="['fas', 'pencil']" fixed-width class="mr-2"></font-awesome-icon>Edit
            </KebabMenuItemLink>
            <KebabMenuItemLink :href="route('creator.campaigns.roles.index', { campaign: campaignStore.campaignId })">
              <font-awesome-icon :icon="['fas', 'person-circle-plus']" fixed-width
                class="mr-2"></font-awesome-icon>Permissions
            </KebabMenuItemLink>
            <KebabMenuItemButton :func="deleteCampaign" :args="[campaign]" is-destructive>
              <font-awesome-icon :icon="['fas', 'trash']" fixed-width class="mr-2"></font-awesome-icon>Delete
            </KebabMenuItemButton>
          </template>
        </DropDownMenu>
      </div>
    </div>
  </image-card>
</template>