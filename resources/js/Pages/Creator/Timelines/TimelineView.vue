<script setup lang="ts">
  import { PropType } from 'vue';
  import { useCampaignStore } from '../../../stores';
  import { type TimelineEntityInterface } from '../../../types/entities/timeline';
  import ContentGroup from '../../../Components/elements/ContentGroup.vue'
  import TimelineLinear from '../../../Components/timeline/linear/TimelineLinear.vue'
  import LinkButton from '../../../Components/buttons/LinkButton.vue';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import { Link } from '@inertiajs/vue3';

  const campaignStore = useCampaignStore()

  const props = defineProps({
    timeline: { type: Object as PropType<TimelineEntityInterface>, required: true }
  })

  const upLink = (props.timeline.parent_id)
    ? route('creator.campaigns.timelines.show', { campaign: campaignStore.selectedCampaignId, timeline: props.timeline.parent_id })
    : route('creator.campaigns.timelines.index', { campaign: campaignStore.selectedCampaignId })
</script>

<template>
  <CreatorDefaultContentLayout>
    <div>
      <Link :href="upLink" class="inline-block w-auto"><font-awesome-icon :icon="['fas', 'angles-left']" /> Back to {{
        timeline.parent?.name ?? 'root' }}</Link>
    </div>
    <PageHeader>
      <template #title>{{ timeline.name }}</template><template #action>
        <LinkButton
          :href="route('creator.campaigns.timelines.edit', { campaign: campaignStore.selectedCampaignId, timeline: timeline.id })"
          :icon="['fas', 'pencil']">Edit {{
            timeline.name ? timeline.name : 'Timeline' }}</LinkButton>
      </template>
    </PageHeader>
    <ContentGroup><template #content>{{ timeline.description }}</template></ContentGroup>
    <ContentGroup v-if="timeline.parent"><template #heading>Parent timeline</template><template #content>
        <Link
          :href="route('creator.campaigns.timelines.show', { campaign: campaignStore.selectedCampaignId, timeline: timeline.parent_id })">
        {{
          timeline.parent.name }}</Link>
      </template></ContentGroup>
    <div>
      <h3 class="mb-2 font-bold">Child timelines</h3>
      <div v-if="timeline.children">
        <TimelineLinear v-if="timeline.children" :timeline-events="timeline.children"
          :campaign-id="campaignStore.selectedCampaignId">
        </TimelineLinear>
      </div>
      <div v-else class="text-center pb-4">
        No child timelines
      </div>
    </div>
    <div class="flex justify-center">
      <LinkButton
        :href="route('creator.campaigns.timelines.create', { campaign: campaignStore.selectedCampaignId, parent_id: timeline.id })">
        <font-awesome-icon :icon="['fas', 'plus']" fixed-width class="mr-2" />Add child
        timeline
      </LinkButton>
    </div>
  </CreatorDefaultContentLayout>
</template>