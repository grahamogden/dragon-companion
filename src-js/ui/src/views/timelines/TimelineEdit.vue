<script setup lang="ts">
  import { ref, reactive } from 'vue';
  import { useTimelineStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import TimelineForm from './TimelineForm.vue'
  import { type TimelineEntityInterface } from '../../services/timeline/TimelineEntityInterface';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue';
import { TimelineEntity } from '../../services/timeline';

  const isLoading = ref(true)
  const timelineStore = useTimelineStore()
  const campaignStore = useCampaignStore()

  const params = router.currentRoute.value.params
  const campaignId = parseInt(params.externalCampaignId as string)
  const timelineId = parseInt(params.timelinesId as string)
  console.debug(campaignId)
  console.debug(timelineId)
  let formData = ref<TimelineEntityInterface>(new TimelineEntity())

  if (campaignStore.selectedCampaignId) {
    timelineStore.getOneTimeline(campaignId, timelineId)
    .then((timeline) => {
      if (timeline !== null) {
        formData.value.id = timeline.id
        formData.value.title = timeline.title
        formData.value.body = timeline.body
        formData.value.parent_id = timeline.parent_id
      }
      isLoading.value = false
    })
  }
  // if (timeline !== undefined && timeline !== null) {
  //   formData = reactive(timeline)
  // }

  async function editTimeline(formData: TimelineEntityInterface): Promise<void> {
    if (campaignStore.selectedCampaignId) {
      await timelineStore.updateTimeline(
        campaignId,
        {
          id: timelineId,
          title: formData.title,
          body: formData.body,
          parent_id: formData.parent_id,
        }
      )
      // console.debug('Editing Timeline')
      router.push({ name: 'timelines.list' })
    }
    // alert('Please select a campaign before editing a timeline!')
  }
</script>

<template>
  <div class="timeline-edit">
    <page-header>Edit "{{ formData.title ? formData.title : 'Unknown' }}" Timeline</page-header>
    <loading-page v-model="isLoading">
      <template #content>
        <timeline-form :data="formData" @save-Timeline="editTimeline" />
      </template>
      <template #loading-text>timeline</template>
    </loading-page>
  </div>
</template>