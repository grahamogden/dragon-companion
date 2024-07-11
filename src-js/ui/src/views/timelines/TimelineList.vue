<script setup lang="ts">
  import { ref } from 'vue';
  import { useTimelineStore, useCampaignStore } from '../../stores'
  import { DropDownItemRouter, DropDownItemButton } from '../../components/interfaces/drop-down.item.interface'
  import type { TimelineEntityInterface } from '../../services/timeline'
  import PageHeader from '../../components/page-header/PageHeader.vue'
  import EntityPage from '../../components/entity-page/EntityPage.vue'
  import EntityTable from '../../components/entity-table/EntityTable.vue'

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
        // allTimeline.value = await timelineStore.fetchTimeline(campaignId)
        fetchTimeline(campaignId)
      })
    }
  }

  function getLinks(campaignId: number, timeline: TimelineEntityInterface): (DropDownItemRouter | DropDownItemButton)[] {
    return [
      new DropDownItemRouter(
        'Edit',
        { name: 'timelines.edit', params: { externalCampaignId: campaignId, timelineId: timeline.id } },
      ),
      new DropDownItemButton(
        'Delete',
        {
          func: confirmDelete,
          args: [campaignId, timeline.id],
        }
      )
    ]
  }
</script>

<template>
  <div class="timeline-list">
    <page-header link-text="Add timeline" :link-destination="{ name: 'timelines.add' }" >Timeline</page-header>
    <entity-page v-if="campaignStore.selectedCampaignId" v-model="isLoading">
      <template #content>
        <!-- <table class="entity-list-table">
          <thead>
            <tr>
              <th>Name</th>
              <th aria-label="Actions"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="timeline in allTimeline">
              <td><router-link :to="{ name: 'timeline.view', params: { externalCampaignId: campaignStore.selectedCampaignId, timelineId: timeline.id } }">{{
                  timeline.name
                  }}</router-link></td>
              <td class="action-cell w-fit">
                <KebabMenu :links="getLinks(campaignStore.selectedCampaignId, timeline)" :button-aria-context-name="'Timeline ' + timeline.name" />
              </td>
            </tr>
          </tbody>
        </table> -->
        <entity-table :headings="['title', 'body']" :entities="allTimelines" :link="{name: 'timelines.edit', idName: 'timelinesId' }" :delete-confirmation-function="confirmDelete" aria-context="Timeline"></entity-table>
      </template>
      <template #loading-text>timeline</template>
    </entity-page>
  </div>
</template>
