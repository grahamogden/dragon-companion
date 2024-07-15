<script setup lang="ts">
  import { ref } from 'vue';
  import { useTimelineStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import TimelineForm from './TimelineForm.vue'
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { useRoute } from 'vue-router';

  const isLoading = ref<boolean>(true)
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const timelineStore = useTimelineStore()
  const route = useRoute()

  const timeline = ref<TimelineEntityInterface>(new TimelineEntity())

  function fetchTimelines() {
    isLoading.value = true
    const params = route.params
    const timelineId = parseInt(params.timelineId as string)

    timelineStore.findOneTimeline(campaignId, timelineId)
      .then((timelineRes) => {
        if (timelineRes !== null) {
          timeline.value = timelineRes
        }
        isLoading.value = false
      })
  }

  fetchTimelines()

  function updateTimeline(): void {
    timelineStore.updateTimeline(
      campaignId,
      timeline.value
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