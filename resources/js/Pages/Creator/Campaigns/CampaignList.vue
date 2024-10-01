<script setup lang="ts">
  import { PropType } from 'vue'
  import CampaignListCard from '../../../Components/campaigns/cards/CampaignListCard.vue';
  import { type CampaignEntityInterface } from '../../../types/entities/campaign'
  import Pagination from '../../../Components/Pagination/Pagination.vue'
  import type PaginationInterface from '../../../types/pagination/pagination.interface';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import { Head } from '@inertiajs/vue3';

  defineProps({
    campaigns: { type: Object as PropType<PaginationInterface<CampaignEntityInterface>>, required: true },
  })
</script>

<template>

  <Head title="Campaigns" />
  <CreatorDefaultContentLayout>
    <PageHeaderWithLink :href="route('creator.campaigns.create')">
      <template #title>Campaigns</template><template #link><font-awesome-icon :icon="['fas', 'plus']" fixed-width
          class="mr-2" />Add campaign</template>
    </PageHeaderWithLink>
    <div
      class="grid gap-default md:gap-default-md grid-cols-1 xs:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 grid-flow-row justify-between justify-items-stretch">
      <CampaignListCard v-for="campaign in campaigns.data" :campaign="campaign"></CampaignListCard>
    </div>
    <Pagination :pagination="campaigns"></Pagination>
  </CreatorDefaultContentLayout>
</template>