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
  // const params = router.currentRoute.value.params
  const params = route.params
  // console.debug(params)
  const campaign = useCampaignStore()
  // const campaignId = parseInt(params.externalCampaignId as string)
  const campaignId = campaign.selectedCampaignId
  let timelineId = parseInt(params.timelineId as string)
  let isLoading = ref(true)
  let formData = ref<TimelineEntityInterface>(new TimelineEntity())

  function fetchTimeline(campaignId: number, timelineId: number) {
    timelineStore.findOneTimeline(campaignId, timelineId, true).then((timeline) => {
      // console.debug(timeline)
      if (timeline !== null) {
        formData.value.id = timeline.id
        formData.value.title = timeline.title
        formData.value.body = timeline.body
        formData.value.parent_id = timeline.parent_id
        formData.value.child_timelines = timeline.child_timelines
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
    <page-header link-text="Edit" :link-destination="{ name: 'timelines.edit', params: { externalCampaignId: campaignId, timelineId: timelineId } }">{{ formData.title ? formData.title : 'Timeline' }}</page-header>
    <loading-page v-model="isLoading">
      <template #content>
        <content-group><template #content>{{ formData.body }}</template></content-group>
        <content-group v-if="formData.parent_id"><template #heading>Parent timeline</template><template #content><router-link :to="{ name: 'timelines.view', params: { externalCampaignId: campaignId, timelineId: formData.parent_id } }">{{ formData.parent_id }}</router-link></template></content-group>
        <content-group>
          <template #heading>Child timelines</template>
          <template #content>
            <view-list-table
            :campaign-id="campaignId"
            :timeline-id="timelineId"
            :headings="[new EntityTableHeading('title', true), new EntityTableHeading('body')]"
            :entities="formData.child_timelines"
            :view-link="new EntityTableLink('timelines.view', 'timelineId')"
            :edit-link="new EntityTableLink('timelines.edit', 'timelineId')"
            :delete-confirmation-function="confirmDelete"
            kebab-menu-button-aria-context="Timeline"></view-list-table>
          </template>
        </content-group>
      </template>
      <template #loading-text>timeline</template>
    </loading-page>
  </div>
</template>