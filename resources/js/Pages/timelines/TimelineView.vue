<script setup lang="ts">
  import { ref, watch } from 'vue';
  import { useCampaignStore, useTimelineStore } from '../../stores';
  import { TimelineEntity, type TimelineEntityInterface } from '../../services/timeline';
  import PageHeader from '../../Components/page-header/PageHeader.vue';
  import LoadingPage from '../../Components/loading-page/LoadingPage.vue'
  import EntityTableLink from '../../Components/entity-table/interface/entity-table-link'
  import ContentGroup from '../../Components/elements/ContentGroup.vue'
  import { useRoute } from 'vue-router'
  import TimelineLinear from '../../Components/timeline/linear/TimelineLinear.vue'
  import TimelineLinearItemCard from '../../Components/timeline/linear/items/TimelineLinearItemCard.vue'
  import { NodePositionEnum } from '../../Components/timeline/linear/interface/timeline.linear.item.node-position.interface';
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../Components/page-header/interface'
  import LinkButton from '../../Components/buttons/LinkButton.vue';

  const route = useRoute()
  const timelineStore = useTimelineStore()
  const params = route.params
  const campaign = useCampaignStore()
  const campaignId = campaign.selectedCampaignId!

  let timelineId = parseInt(params.timelineId as string)
  let isLoading = ref(true)
  let timeline = ref<TimelineEntityInterface>(new TimelineEntity())

  function fetchTimeline(campaignId: number, timelineId: number) {
    isLoading.value = true
    timelineStore.findOneTimeline(campaignId, timelineId, true).then((timelineRes) => {
      if (timelineRes !== null) {
        timeline.value = timelineRes
      }
      isLoading.value = false
    })
  }

  fetchTimeline(campaignId, timelineId)

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      timelineStore.deleteTimeline(campaignId, id).then(() => {
        fetchTimeline(campaignId, timelineId)
      })
    }
  }

  watch(
    () => route.params.timelineId,
    (newId, oldId) => {
      isLoading.value = true
      timelineId = parseInt(newId as string)
      fetchTimeline(campaignId, timelineId)
    })
</script>

<template>
  <div class="timeline-view">
    <PageHeader
      :link="new PageHeaderLink('Edit', { name: 'timelines.edit', params: { externalCampaignId: campaignId, timelineId: timelineId } }, PageHeaderLinkActionEnum.EDIT)">
      {{
        timeline.title ? timeline.title : 'Timeline' }}</PageHeader>
    <LoadingPage :is-loading="isLoading">
      <template #content>
        <ContentGroup><template #content>{{ timeline.body }}</template></ContentGroup>
        <ContentGroup v-if="timeline.parent_id"><template #heading>Parent timeline</template><template
            #content><router-link
              :to="{ name: 'timelines.view', params: { externalCampaignId: campaignId, timelineId: timeline.parent_id } }">{{
                timeline.parent_id }}</router-link></template></ContentGroup>
        <h3 class="mb-2 font-bold">Child timelines</h3>
        <div v-if="(timeline.child_timelines?.length ?? 0) > 0" class="mt-4 md:px-6">
          <TimelineLinear v-if="timeline.child_timelines">
            <TimelineLinearItemCard v-for="(timelineItem, key) in timeline.child_timelines" :campaignId="campaignId"
              :node-position="key === 0 ? NodePositionEnum.start : (key + 1) === timeline.child_timelines.length ? NodePositionEnum.end : NodePositionEnum.both"
              :entity="timelineItem" :view-link="new EntityTableLink('timelines.view', 'timelineId')"
              :edit-link="new EntityTableLink('timelines.edit', 'timelineId')"
              :delete-confirmation-function="confirmDelete" kebab-menu-button-aria-context="Timeline">
            </TimelineLinearItemCard>
          </TimelineLinear>
        </div>
        <div v-else class="text-center pb-4">
          No child timelines
        </div>
        <div class="flex justify-center">
          <LinkButton :href="{ name: 'timelines.add', params: { campaignId: campaignId } }">
            <font-awesome-icon :icon="['fas', 'plus']" fixed-width class="mr-2" />Add child
            timeline
          </LinkButton>
        </div>
      </template>
      <template #loading-text>timeline</template>
    </LoadingPage>
  </div>
</template>