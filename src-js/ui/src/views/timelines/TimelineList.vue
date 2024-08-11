<script setup lang="ts">
  import { ref } from 'vue';
  import { useTimelineStore, useCampaignStore, useNotificationStore } from '../../stores'
  import type { TimelineEntityInterface } from '../../services/timeline'
  import PageHeader from '../../components/page-header/PageHeader.vue'
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import IndexListTable from '../../components/timeline/index-list-table/IndexListTable.vue'
  import EntityTableHeading from '../../components/entity-table/interface/entity-table-heading'
  import EntityTableLink from '../../components/entity-table/interface/entity-table-link'
  import TimelineLinear from '../../components/timeline/linear/TimelineLinear.vue'
  import TimelineLinearItemCard from '../../components/timeline/linear/items/TimelineLinearItemCard.vue'
  import { NodePositionEnum } from '../../components/timeline/linear/interface/timeline.linear.item.node-position.interface';
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../components/page-header/interface';

  const notificationStore = useNotificationStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const timelineStore = useTimelineStore()
  const isLoading = ref(true)

  let allTimelines: TimelineEntityInterface[] = []
  fetchTimelines(campaignId)

  function fetchTimelines(campaignId: number): void {
    isLoading.value = true
    timelineStore.findTimelines(campaignId, false, 0).then((timelines: TimelineEntityInterface[]) => {
      if (timelines !== null) {
        allTimelines = timelines
      }
      isLoading.value = false
    });
  }

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      notificationStore.removeAllNotifications()
      timelineStore.deleteTimeline(campaignId, id).then(() => {
        notificationStore.addSuccess('Successfully deleted timeline')
        fetchTimelines(campaignId)
      })
    }
  }
</script>

<template>
  <div class="timeline-list">
    <page-header
      :link="new PageHeaderLink('Add timeline', { name: 'timelines.add' }, PageHeaderLinkActionEnum.ADD)">Timelines</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <timeline-linear>
          <timeline-linear-item-card v-for="(timelineItem, key) in allTimelines" :campaignId="campaignId"
            :node-position="key === 0 ? NodePositionEnum.start : (key + 1) === allTimelines.length ? NodePositionEnum.end : NodePositionEnum.both"
            :entity="timelineItem" :view-link="new EntityTableLink('timelines.view', 'timelineId')"
            :edit-link="new EntityTableLink('timelines.edit', 'timelineId')"
            :delete-confirmation-function="confirmDelete"
            kebab-menu-button-aria-context="Timeline"></timeline-linear-item-card>
        </timeline-linear>
        <!-- <index-list-table :campaign-id="campaignId"
          :headings="[new EntityTableHeading('title', true), new EntityTableHeading('body')]" :entities="allTimelines"
          :view-link="new EntityTableLink('timelines.view', 'timelineId')"
          :edit-link="new EntityTableLink('timelines.edit', 'timelineId')" :delete-confirmation-function="confirmDelete"
          kebab-menu-button-aria-context="Timeline"></index-list-table> -->
      </template>
      <template #loading-text>timeline</template>
    </loading-page>
  </div>
</template>
