<script setup lang="ts">
  import { ref, reactive } from 'vue';
  import { useTimelineStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import TimelineForm from './TimelineForm.vue'
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue';
  import type SelectInputOptionInterface from '../../components/elements/interface/select-input-option.interface'
  import { useRoute } from 'vue-router';

  const isLoading = ref(true)
  const timelineStore = useTimelineStore()
  const campaignStore = useCampaignStore()
  const route = useRoute()
  const formData = ref<TimelineEntityInterface>(new TimelineEntity())
  const timelineId = ref<number | null>(null)
  const timelineOptions = ref<SelectInputOptionInterface[]>([]);

  function findTimelines() {
    const params = route.params
    const campaignId = campaignStore.selectedCampaignId
    // const campaignId = parseInt(params.externalCampaignId as string)
    timelineId.value = parseInt(params.timelineId as string)
    // console.debug(campaignId)
    // console.debug(campaignStore.selectedCampaignId)
    // console.debug(timelineId)

    // const timelineOptions: SelectInputOptionInterface[] = [];

    if (campaignStore.selectedCampaignId && campaignId === campaignStore.selectedCampaignId) {
      timelineStore.findOneTimeline(campaignId, timelineId.value)
        .then((timeline) => {
          if (timeline !== null) {
            formData.value.id = timeline.id
            formData.value.title = timeline.title
            formData.value.body = timeline.body
            formData.value.parent_id = timeline.parent_id
          }
          isLoading.value = false
        })

      // timelineStore.findTimelines(campaignId)
      //   .then((timelines) => {
      //     timelines.forEach((timeline) => {
      //       console.dir(timeline)
      //       if (timeline.id === timelineId.value) {
      //         formData.value.id = timeline.id
      //         formData.value.title = timeline.title
      //         formData.value.body = timeline.body
      //         formData.value.parent_id = timeline.parent_id
      //         formData.value.child_timelines = timeline.child_timelines
      //       } else if (timeline.id !== null) {
      //         timelineOptions.value.push({ value: timeline.id, text: timeline.title })
      //       }
      //     })
      //     isLoading.value = false
      //   })
    }
    // if (timeline !== undefined && timeline !== null) {
    //   formData = reactive(timeline)
    // }
  }

  findTimelines()

  async function editTimeline(formData: TimelineEntityInterface): Promise<void> {
    if (campaignStore.selectedCampaignId && timelineId.value) {
      await timelineStore.updateTimeline(
        campaignStore.selectedCampaignId,
        {
          id: timelineId.value,
          title: formData.title,
          body: formData.body,
          parent_id: formData.parent_id,
          child_timelines: formData.child_timelines
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
        <timeline-form :data="formData" :parent-id-options="timelineOptions" @save-Timeline="editTimeline" />
      </template>
      <template #loading-text>timeline</template>
    </loading-page>
  </div>
</template>