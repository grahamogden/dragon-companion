<script setup lang="ts">
  import { PropType } from 'vue'
  import CampaignListCard from '../../../Components/campaigns/cards/CampaignListCard.vue';
  import { type CampaignEntityInterface } from '../../../types/entities/campaign'
  import Pagination from '../../../Components/Pagination/Pagination.vue'
  import { type PaginationInterface } from '../../../types/pagination/pagination.interface';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import Card from 'primevue/card';
  import Button from '../../../Components/buttons/Button.vue';
  import LinkButton from '../../../Components/buttons/LinkButton.vue';

  defineProps({
    campaigns: { type: Object as PropType<PaginationInterface<CampaignEntityInterface>>, required: true },
  })
</script>

<template>

  <Head title="Campaigns" />
  <CreatorDefaultContentLayout>
    <PageHeader>
      <template #title>Campaigns</template><template #action>
        <LinkButton :href="route('creator.campaigns.create')" :icon="['fas', 'plus']">Add campaign</LinkButton>
      </template>
    </PageHeader>
    <div
      class="grid gap-default md:gap-default-md grid-cols-1 xs:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 grid-flow-row justify-between justify-items-stretch">
      <CampaignListCard v-for="campaign in campaigns.data" :key="campaign.id" :campaign="campaign">
      </CampaignListCard>
    </div>
    <Pagination :pagination="campaigns"></Pagination>
  </CreatorDefaultContentLayout>
</template>