<script setup lang="ts">
  import { ref, watch } from 'vue';
  import { useCampaignStore, useTimelineStore } from '../../stores';
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import ViewListTable from '../../components/timeline/view-list-table/ViewListTable.vue'
  import EntityTableHeading from '../../components/entity-table/interface/entity-table-heading'
  import EntityTableLink from '../../components/entity-table/interface/entity-table-link'
  import ContentGroup from '../../components/elements/ContentGroup.vue'
  import { useRoute } from 'vue-router'

  const route = useRoute()
  const timelineStore = useTimelineStore()
  const params = route.params
  const campaign = useCampaignStore()
  const campaignId = campaign.selectedCampaignId!

  let timelineId = parseInt(params.timelineId as string)
  let isLoading = ref(true)
  let timeline = ref<TimelineEntityInterface>(new TimelineEntity())

  function fetchTimeline(campaignId: number, timelineId: number) {
    isLoading.value = true
    timelineStore.findOneTimeline(campaignId, timelineId, true).then((timelineRes) => {
      // console.debug(timeline)
      if (timelineRes !== null) {
        timeline.value.id = timelineRes.id
        timeline.value.title = timelineRes.title
        timeline.value.body = timelineRes.body
        timeline.value.parent_id = timelineRes.parent_id
        timeline.value.child_timelines = timelineRes.child_timelines
      }
      isLoading.value = false
    })
  }

  fetchTimeline(campaignId, timelineId)

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      timelineStore.deleteTimeline(campaignId, id).then(() => {
        fetchTimeline(campaignId, timelineId)
      })
    }
  }

  watch(
    () => route.params.timelineId,
    (newId, oldId) => {
      isLoading.value = true
      timelineId = parseInt(newId as string)
      fetchTimeline(campaignId, timelineId)
    })
</script>

<template>
  <div class="timeline-view">
    <page-header link-text="Edit"
      :link-destination="{ name: 'timelines.edit', params: { externalCampaignId: campaignId, timelineId: timelineId } }">{{
        timeline.title ? timeline.title : 'Timeline' }}</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <content-group><template #content>{{ timeline.body }}</template></content-group>
        <content-group v-if="timeline.parent_id"><template #heading>Parent timeline</template><template
            #content><router-link
              :to="{ name: 'timelines.view', params: { externalCampaignId: campaignId, timelineId: timeline.parent_id } }">{{
        timeline.parent_id }}</router-link></template></content-group>
        <content-group>
          <template #heading>Child timelines</template>
          <template #content>
            <view-list-table :campaign-id="campaignId" :timeline-id="timelineId"
              :headings="[new EntityTableHeading('title', true), new EntityTableHeading('body')]"
              :entities="timeline.child_timelines" :view-link="new EntityTableLink('timelines.view', 'timelineId')"
              :edit-link="new EntityTableLink('timelines.edit', 'timelineId')"
              :delete-confirmation-function="confirmDelete" kebab-menu-button-aria-context="Timeline"></view-list-table>
          </template>
        </content-group>
      </template>
      <template #loading-text>timeline</template>
    </loading-page>
  </div>
</template>