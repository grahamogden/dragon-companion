<script setup lang="ts">
  import { useCampaignStore } from '../../../stores'
  import type { TimelineEntityInterface } from '../../../types/entities/timeline'
  import TimelineLinear from '../../../Components/timeline/linear/TimelineLinear.vue'
  import { Head } from '@inertiajs/vue3';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
  import PaginationInterface from '../../../types/pagination/pagination.interface';
  import { PropType } from 'vue'
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue'

  const props = defineProps({
    timelines: Object as PropType<PaginationInterface<TimelineEntityInterface>>,
  })

  const campaignStore = useCampaignStore()

  // let allTimelines: TimelineEntityInterface[] = []
  // fetchTimelines(campaignId)

  // function fetchTimelines(campaignId: number): void {
  //   isLoading.value = true
  //   timelineStore.findTimelines(campaignId, false, 0).then((timelines: TimelineEntityInterface[]) => {
  //     if (timelines !== null) {
  //       allTimelines = timelines
  //     }
  //     isLoading.value = false
  //   });
  // }

  // function confirmDelete(campaignId: number, id: number): void {
  //   if (window.confirm('Are you sure you want to delete ' + id)) {
  //     notificationStore.removeAllNotifications()
  //     timelineStore.deleteTimeline(campaignId, id).then(() => {
  //       notificationStore.addSuccess('Successfully deleted timeline')
  //       fetchTimelines(campaignId)
  //     })
  //   }
  // }
</script>

<template>

  <Head title="Timelines" />
  <CreatorDefaultContentLayout>
    <PageHeaderWithLink
      :href="route('creator.campaigns.timelines.create', { campaign: campaignStore.selectedCampaignId })">
      <template #title>Timelines</template><template #link><font-awesome-icon :icon="['fas', 'plus']" fixed-width
          class="mr-2" />Add timeline event</template>
    </PageHeaderWithLink>
    <TimelineLinear :timeline-events="timelines.data" :campaign-id="campaignStore.selectedCampaignId"></TimelineLinear>
    <!-- <index-list-table :campaign-id="campaignId"
     

        :view-link="new EntityTableLink('timelines.view', 'timelineId')"
        :edit-link="new EntityTableLink('timelines.edit', 'timelineId')" 
        :delete-confirmation-function="confirmDelete"
    
    
        :headings="[new EntityTableHeading('title', true), new EntityTableHeading('body')]" :entities="allTimelines"
          :view-link="new EntityTableLink('timelines.view', 'timelineId')"
          :edit-link="new EntityTableLink('timelines.edit', 'timelineId')" :delete-confirmation-function="confirmDelete"
          kebab-menu-button-aria-context="Timeline"></index-list-table> -->
  </CreatorDefaultContentLayout>
</template>
