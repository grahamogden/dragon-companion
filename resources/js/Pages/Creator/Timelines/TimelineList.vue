<script setup lang="ts">
  import { useCampaignStore } from '../../../stores'
  import type { TimelineEntityInterface } from '../../../types/entities/timeline'
  import TimelineLinear from '../../../Components/timeline/linear/TimelineLinear.vue'
  import { Head } from '@inertiajs/vue3';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import { type PaginationInterface } from '../../../types/pagination';
  import { PropType } from 'vue'
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue'
  import LinkButton from '../../../Components/buttons/LinkButton.vue';

  const props = defineProps({
    timelines: Object as PropType<PaginationInterface<TimelineEntityInterface>>,
  })

  const campaignStore = useCampaignStore()
</script>

<template>

  <Head title="Timelines" />
  <CreatorDefaultContentLayout>
    <PageHeader>
      <template #title>Timelines</template><template #action>
        <LinkButton :href="route('creator.campaigns.timelines.create', { campaign: campaignStore.selectedCampaignId })"
          :icon="['fas', 'plus']">Add timeline event</LinkButton>
      </template>
    </PageHeader>
    <TimelineLinear :timeline-events="timelines.data" :campaign-id="campaignStore.selectedCampaignId"></TimelineLinear>
  </CreatorDefaultContentLayout>
</template>
