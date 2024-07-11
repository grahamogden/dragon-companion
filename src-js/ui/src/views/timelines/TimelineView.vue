<script setup lang="ts">
  import { ref } from 'vue';
  import { useTimelineStore } from '../../stores';
  import router from '../../router';
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import EntityPage from '../../components/entity-page/EntityPage.vue'

  const timelineStore = useTimelineStore()
  const params = router.currentRoute.value.params
  // console.debug(router.currentRoute.value)
  // console.debug(router.currentRoute.value.params)
  const campaignId = parseInt(params.externalCampaignId as string)
  const timelineId = parseInt(params.timelinesId as string)
  let isLoading = ref(true)
  let formData = ref<TimelineEntityInterface>(new TimelineEntity())

  timelineStore.getOneTimeline(campaignId, timelineId).then((timeline) => {
    // console.debug(timeline)
    if (timeline !== null) {
      formData.value.id = timeline.id
      formData.value.title = timeline.title
      formData.value.body = timeline.body
      formData.value.parent_id = timeline.parent_id
    }
    isLoading.value = false
  })
</script>

<template>
  <div class="timeline-view">
    <page-header link-text="Edit" :link-destination="{ name: 'timelines.edit', params: { externalCampaignId: campaignId, timelineId: timelineId } }">{{ formData.title ? formData.title : 'Timeline' }}</page-header>
    <entity-page v-model="isLoading">
      <template #content>
        <div>{{ formData.title }}</div>
        <div>{{ formData.body }}</div>
        <div>{{ formData.parent_id }}</div>
      </template>
      <template #loading-text>timeline</template>
    </entity-page>
  </div>
</template>