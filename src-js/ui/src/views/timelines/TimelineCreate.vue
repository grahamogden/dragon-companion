<script setup lang="ts">
  import { useTimelineStore } from '../../stores/timeline';
  import router from '../../router';
  import TimelineForm from './TimelineForm.vue';
  import { type TimelineEntityInterface } from '../../services/timeline/TimelineEntityInterface';
  import { useCampaignStore } from '../../stores';
  import PageHeader from '../../components/page-header/PageHeader.vue';

  const timelineStore = useTimelineStore()
  const campaignStore = useCampaignStore()

  async function createTimeline(formData: TimelineEntityInterface): Promise<void> {
    if (campaignStore.selectedCampaignId) {
      await timelineStore.addTimeline(
        campaignStore.selectedCampaignId,
        {
          title: formData.title,
          body: formData.body,
          parent_id: formData.parent_id,
        }
      )
      router.push({ name: 'timelines.list', params: { externalCampaignId: campaignStore.selectedCampaignId } })
    } else {
      alert('Please select a campaign to save a new timeline')
    }
  }
</script>

<template>
  <div class="timeline-create">
    <page-header>Create a Timeline</page-header>
    <TimelineForm @save-Timeline="createTimeline" />
  </div>
</template>