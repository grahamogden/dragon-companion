<script setup lang="ts">
  import { ref } from 'vue';
  import { useTimelineStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import TimelineForm from './TimelineForm.vue'
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { useRoute } from 'vue-router';

  const timelineStore = useTimelineStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const route = useRoute()
  const isLoading = ref<boolean>(true)

  const timeline = ref<TimelineEntityInterface>(new TimelineEntity())

  function fetchTimelines() {
    const params = route.params
    const timelineId = parseInt(params.timelineId as string)

    timelineStore.findOneTimeline(campaignId, timelineId)
      .then((timelineRes) => {
        if (timelineRes !== null) {
          timeline.value.id = timelineRes.id
          timeline.value.title = timelineRes.title
          timeline.value.body = timelineRes.body
          timeline.value.parent_id = timelineRes.parent_id
        }
        isLoading.value = false
      })
  }

  fetchTimelines()

  function updateTimeline(): void {
    timelineStore.updateTimeline(
      campaignId,
      new TimelineEntity(
        timeline.value.id,
        timeline.value.title,
        timeline.value.body,
        timeline.value.parent_id,
      )
    ).then(() => {
      router.push({ name: 'timelines.list' })
    })
  }
</script>

<template>
  <div class="timeline-edit">
    <page-header>Edit "{{ timeline.title ? timeline.title : 'Unknown' }}" Timeline</page-header>
    <timeline-form :campaign-id="campaignId" @save-Timeline="updateTimeline" v-model:timeline="timeline"
      :is-parent-loading="isLoading" />
  </div>
</template>