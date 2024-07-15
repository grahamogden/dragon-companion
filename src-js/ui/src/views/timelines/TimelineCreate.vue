<script setup lang="ts">
  import { useTimelineStore } from '../../stores/timeline';
  import router from '../../router';
  import TimelineForm from './TimelineForm.vue';
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import { useCampaignStore } from '../../stores';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { ref } from 'vue';
  import { useRoute } from 'vue-router';

  const timelineStore = useTimelineStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const route = useRoute();

  const timeline = ref<TimelineEntityInterface>(new TimelineEntity())

  timeline.value.parent_id = parseInt(route.query.parentId as string)

  function createTimeline(): void {
    timelineStore.addTimeline(
      campaignId,
      new TimelineEntity(
        undefined,
        timeline.value.title,
        timeline.value.body,
        timeline.value.parent_id,
      )
    ).then(() => {
      router.push({ name: 'timelines.list', params: { externalCampaignId: campaignId } })
    })
  }
</script>

<template>
  <div class="timeline-create">
    <page-header>Create a Timeline</page-header>
    <timeline-form :campaign-id="campaignId" @save-Timeline="createTimeline" v-model:timeline="timeline" :is-parent-loading="false" />
  </div>
</template>