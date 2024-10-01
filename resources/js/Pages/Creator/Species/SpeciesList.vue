<script setup lang="ts">
  import { PropType } from 'vue';
  import { useCampaignStore } from '../../../stores'
  import type { SpeciesEntityInterface, SpeciesIndexEntityInterface } from '../../../types/entities/species'
  import EntityTable from '../../../Components/entity-table/EntityTable.vue'
  import EntityTableHeading from '../../../Components/entity-table/interface/entity-table-heading';
  import PaginationInterface from '../../../types/pagination/pagination.interface';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import { Head } from '@inertiajs/vue3';

  const campaignStore = useCampaignStore()

  defineProps({
    species: { type: Object as PropType<PaginationInterface<SpeciesIndexEntityInterface>>, required: true }
  })

  // let allSpecies: SpeciesEntityInterface[] = []
  // fetchSpecies(campaignId)

  // function fetchSpecies(campaignId: number): void {
  //   isLoading.value = true
  //   speciesStore.fetchSpecies(campaignId).then((speciesRes: SpeciesEntityInterface[]) => {
  //     if (speciesRes !== null) {
  //       allSpecies = speciesRes
  //     }
  //     isLoading.value = false
  //   });
  // }

  // function confirmDelete(campaignId: number, id: number): void {
  //   if (window.confirm('Are you sure you want to delete ' + id)) {
  //     notificationStore.removeAllNotifications()
  //     speciesStore.deleteSpecies(campaignId, id).then(() => {
  //       notificationStore.addSuccess('Successfully deleted species')
  //       fetchSpecies(campaignId)
  //     })
  //   }
  // }
</script>

<template>

  <Head title="Species" />
  <CreatorDefaultContentLayout>
    <PageHeaderWithLink
      :href="route('creator.campaigns.species.create', { campaign: campaignStore.selectedCampaignId })">
      <template #title>Species</template><template #link><font-awesome-icon :icon="['fas', 'plus']" fixed-width
          class="mr-2" />Add species</template>
    </PageHeaderWithLink>
    <EntityTable :headings="[new EntityTableHeading('name', true), new EntityTableHeading('description')]"
      :entities="species.data" kebab-menu-button-aria-context="Species"></EntityTable>
  </CreatorDefaultContentLayout>
</template>