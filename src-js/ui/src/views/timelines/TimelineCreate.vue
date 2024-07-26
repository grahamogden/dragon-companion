<script setup lang="ts">
  import { useTimelineStore } from '../../stores/timeline';
  import router from '../../router';
  import TimelineForm from './TimelineForm.vue';
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import { useCampaignStore } from '../../stores';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { ref } from 'vue';
  import { useRoute } from 'vue-router';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface'
  import type ValidationError from '../../services/repository/errors/ValidationError';
  import { provide } from 'vue';
  import { errorMessagesKey } from '../../keys'

  const timelineStore = useTimelineStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const route = useRoute();
  const notificationStore = useNotificationStore()

  const timeline = ref<TimelineEntityInterface>(new TimelineEntity())
  const errorMessages = ref<Record<string, ValidationError>>({})
  provide(errorMessagesKey, errorMessages)

  timeline.value.parent_id = parseInt(route.query.parentId as string)

  function createTimeline(): void {
    notificationStore.removeAllNotifications()
    errorMessages.value = {}
    timelineStore.addTimeline(
      campaignId,
      timeline.value
    ).then(() => {
      router.push({ name: 'timelines.list', params: { externalCampaignId: campaignId } })
      notificationStore.addSuccess('Successfully created timeline')
    })
      .catch((error: ApplicationErrorInterface) => {
        console.debug(error)
        notificationStore.addError(error.message)
        errorMessages.value = error.errors || {}
      })
  }
</script>

<template>
  <div class="timeline-create">
    <page-header>Create a Timeline</page-header>
    <timeline-form :campaign-id="campaignId" @save-Timeline="createTimeline" v-model:timeline="timeline"
      :is-parent-loading="false" />
  </div>
</template>