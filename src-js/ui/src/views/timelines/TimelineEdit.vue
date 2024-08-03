<script setup lang="ts">
  import { ref, provide } from 'vue';
  import { useTimelineStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import TimelineForm from './TimelineForm.vue'
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { useRoute } from 'vue-router';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const isLoading = ref<boolean>(true)
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const timelineStore = useTimelineStore()
  const route = useRoute()
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

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
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    timelineStore.updateTimeline(
      campaignId,
      timeline.value
    ).then(() => {
      router.push({ name: 'timelines.list' })
        .then(() => {
          notificationStore.addSuccess('Successfully updated timeline')
        })
    })
      .catch((error: ApplicationErrorInterface) => {
        console.debug(error)
        notificationStore.addError(error.message)
        if (error.errors) {
          validationStore.addErrors(error.errors)
        }
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