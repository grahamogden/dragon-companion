<script setup lang="ts">
  import { useTimelineStore } from '../../stores/timeline';
  import router from '../../router';
  import TimelineForm from './TimelineForm.vue';
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import { useCampaignStore } from '../../stores';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import type SelectInputOptionInterface from '../../components/elements/interface/select-input-option.interface'
  import LoadingPage from '../../components/loading-page/LoadingPage.vue';
  import { ref } from 'vue';
  import { useRoute } from 'vue-router';

  const timelineStore = useTimelineStore()
  const campaignStore = useCampaignStore()
  const isLoading = ref(true)
  const route = useRoute();
  const formData = ref<TimelineEntityInterface>(new TimelineEntity())

  if (!campaignStore.selectedCampaignId) {
    router.push('campaign.list')
  }

  formData.value.parent_id = parseInt(route.query.parentId as string)

  const timelineOptions: SelectInputOptionInterface[] = [];
  timelineStore.findTimelines(campaignStore.selectedCampaignId!, undefined, undefined)
    .then((timelines) => {
      timelines.forEach((timeline) => {
        if (timeline.id) {
          timelineOptions.push({ value: timeline.id, text: timeline.title })
        }
      })
      console.dir(timelineOptions)
      isLoading.value = false
    })

  function createTimeline(formData: TimelineEntityInterface): void {
    if (campaignStore.selectedCampaignId) {
      timelineStore.addTimeline(
        campaignStore.selectedCampaignId,
        new TimelineEntity(
          undefined,
          formData.title,
          formData.body,
          formData.parent_id,
        )
      ).then(() => {
        router.push({ name: 'timelines.list', params: { externalCampaignId: campaignStore.selectedCampaignId } })
      })
    } else {
      alert('Please select a campaign to save a new timeline')
    }
  }
</script>

<template>
  <div class="timeline-create">
    <page-header>Create a Timeline</page-header>
    <loading-page v-model="isLoading">
      <template #content>
        <TimelineForm :parent-id-options="timelineOptions" @save-Timeline="createTimeline" :data="formData" />
      </template>
      <template #loading-text>timeline</template>
    </loading-page>
  </div>
</template>