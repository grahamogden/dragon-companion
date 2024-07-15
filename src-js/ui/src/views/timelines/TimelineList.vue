<script setup lang="ts">
  import { ref } from 'vue';
  import { useTimelineStore, useCampaignStore } from '../../stores'
  import type { TimelineEntityInterface } from '../../services/timeline'
  import PageHeader from '../../components/page-header/PageHeader.vue'
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import IndexListTable from '../../components/timeline/index-list-table/IndexListTable.vue'
  import EntityTableHeading from '../../components/entity-table/interface/entity-table-heading'
  import EntityTableLink from '../../components/entity-table/interface/entity-table-link'

  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const timelineStore = useTimelineStore()
  const isLoading = ref(true)

  let allTimelines: TimelineEntityInterface[] = []
  fetchTimelines(campaignId)

  function fetchTimelines(campaignId: number): void {
    isLoading.value = true
    timelineStore.findTimelines(campaignId, true, 0).then((timelines: TimelineEntityInterface[]) => {
      if (timelines !== null) {
        allTimelines = timelines
      }
      isLoading.value = false
    });
  }

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      timelineStore.deleteTimeline(campaignId, id).then(() => {
        fetchTimelines(campaignId)
      })
    }
  }
</script>

<template>
  <div class="timeline-list">
    <page-header link-text="Add timeline" :link-destination="{ name: 'timelines.add' }" >Timelines</page-header>
    <loading-page v-model="isLoading">
      <template #content>
        <index-list-table
          :campaign-id="campaignId"
          :headings="[new EntityTableHeading('title', true), new EntityTableHeading('body')]"
          :entities="allTimelines"
          :view-link="new EntityTableLink('timelines.view', 'timelineId')"
          :edit-link="new EntityTableLink('timelines.edit', 'timelineId')"
          :delete-confirmation-function="confirmDelete"
          kebab-menu-button-aria-context="Timeline"></index-list-table>
      </template>
      <template #loading-text>timeline</template>
    </loading-page>
  </div>
</template>
