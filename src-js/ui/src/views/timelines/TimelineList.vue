<script setup lang="ts">
  import { ref } from 'vue';
  import { useTimelineStore, useCampaignStore } from '../../stores'
  import type { TimelineEntityInterface } from '../../services/timeline'
  import PageHeader from '../../components/page-header/PageHeader.vue'
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import EntityTable from '../../components/entity-table/EntityTable.vue'
  import EntityTableHeading from '../../components/entity-table/interface/entity-table-heading'
  import EntityTableLink from '../../components/entity-table/interface/entity-table-link'

  const timelineStore = useTimelineStore()
  const campaignStore = useCampaignStore()
  const isLoading = ref(true)

  let allTimelines = ref<TimelineEntityInterface[]>([])
  if (campaignStore.selectedCampaignId) {
    fetchTimeline(campaignStore.selectedCampaignId)
  }

  function fetchTimeline(campaignId: number): void {
    isLoading.value = true
    timelineStore.fetchTimeline(campaignId).then((timeline: TimelineEntityInterface[]) => {
      if (timeline !== null) {
        allTimelines.value = timeline
      }
      isLoading.value = false
    });
  }

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      timelineStore.deleteTimeline(campaignId, id).then(() => {
        fetchTimeline(campaignId)
      })
    }
  }
</script>

<template>
  <div class="timeline-list">
    <page-header link-text="Add timeline" :link-destination="{ name: 'timelines.add' }" >Timelines</page-header>
    <loading-page v-if="campaignStore.selectedCampaignId" v-model="isLoading">
      <template #content>
        <entity-table :headings="[new EntityTableHeading('title', true), new EntityTableHeading('body')]"
          :entities="allTimelines"
          :view-link="new EntityTableLink('timelines.view', 'timelinesId')"
          :edit-link="new EntityTableLink('timelines.edit', 'timelinesId')"
          :delete-confirmation-function="confirmDelete"
          kebab-menu-button-aria-context="Timeline"></entity-table>
      </template>
      <template #loading-text>timeline</template>
    </loading-page>
  </div>
</template>
