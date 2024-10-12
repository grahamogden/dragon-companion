<script setup lang="ts">
  import { useCampaignStore } from '../../../stores/campaign'
  import { useNotificationStore } from '../../../stores/notifications/notification-store'
  import type { CampaignEntity, CampaignEntityInterface } from '../../../types/entities/campaign';
  import { PropType, ref, watch } from 'vue';
  import { router } from '@inertiajs/vue3';
  import Card from 'primevue/card';
  import Button from '../../buttons/Button.vue';
  import DropDownMenu from '../../drop-down/DropDownMenu.vue';
  import KebabMenuItemButton from '../../menu/wrapped-kebab-menu/KebabMenuItemButton.vue';
  import KebabMenuItemLink from '../../menu/wrapped-kebab-menu/KebabMenuItemLink.vue';

  const props = defineProps({
    campaign: { type: Object as PropType<CampaignEntityInterface>, required: true },
  })

  const campaignStore = useCampaignStore()
  const notificationStore = useNotificationStore()
  const campaignIsCurrentlySelected = ref(props.campaign.id === campaignStore.selectedCampaignId)

  function selectCampaign() {
    notificationStore.removeAllNotifications()
    setTimeout(() => {
      campaignStore.selectCampaign(props.campaign.id!, props.campaign.name)
      notificationStore.addSuccess('Campaign "' + campaignStore.campaignName + '" successfully selected')
    }, 250)
  }

  const deleteCampaign = (campaign: CampaignEntity) => {
    console.debug('Confirming delete for ' + campaign.name)
    if (window.confirm('Are you sure you want to delete ' + campaign.name)) {
      console.debug('Confirmed - attempting delete')
      router.delete(route('creator.campaigns.destroy', { campaign: campaign.id }))
    }
  }

  watch(() => campaignStore.selectedCampaignId, (newSelectedCampaignid) => {
    if (newSelectedCampaignid === props.campaign.id) {
      campaignIsCurrentlySelected.value = true
    } else {
      campaignIsCurrentlySelected.value = false
    }
  })
</script>
<template>
  <Card class="rounded-xl">
    <template #header>
      <div class="rounded-t-xl overflow-hidden"><img src="@/assets/images/background/light/full.svg"></div>
    </template>
    <template #title>
      {{ campaign.name }}
    </template>
    <template #footer>
      <div class="flex gap-default justify-between">
        <div>
          <Button type="button" @click="selectCampaign" aria-haspopup :disabled="campaignIsCurrentlySelected"
            :outlined="campaignIsCurrentlySelected" :aria-controls="'overlay-menu-' + campaign.id"
            :icon="campaignIsCurrentlySelected ? ['fas', 'check'] : ['far', 'circle']">{{ campaignIsCurrentlySelected ?
              'Selected' : 'Select' }}
          </Button>
        </div>
        <div>
          <DropDownMenu :button-aria-context-name="'Campaign ' + campaign.name">
            <template #items>
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
    </template>
  </Card>
</template>