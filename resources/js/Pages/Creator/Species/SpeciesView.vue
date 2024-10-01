<script setup lang="ts">
  import { PropType } from 'vue';
  import { useCampaignStore } from '../../../stores';
  import { type SpeciesEntityInterface } from '../../../types/entities/species';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import { Head } from '@inertiajs/vue3';

  const campaignStore = useCampaignStore()

  defineProps({
    species: { type: Object as PropType<SpeciesEntityInterface>, required: true }
  })
</script>

<template>

  <Head :title="species.name + ' Species'" />
  <CreatorDefaultContentLayout>
    <PageHeaderWithLink
      :href="route('creator.campaigns.species.edit', { campaign: campaignStore.selectedCampaignId, species: species.id })">
      <template #title>{{ species.name }} Species</template><template #link><font-awesome-icon :icon="['fas', 'plus']"
          fixed-width class="mr-2" />Edit {{ species.name }}</template>
    </PageHeaderWithLink>
  </CreatorDefaultContentLayout>
</template>