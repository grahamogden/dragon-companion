<script setup lang="ts">
  import { PropType } from 'vue';
  import { useCampaignStore } from '../../../stores'
  import { type SpeciesIndexEntityInterface } from '../../../types/entities/species'
  import EntityTable from '../../../Components/entity-table/EntityTable.vue'
  import EntityTableHeading from '../../../Components/entity-table/interface/entity-table-heading';
  import { type PaginationInterface } from '../../../types/pagination/pagination.interface';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import LinkButton from '../../../Components/buttons/LinkButton.vue';

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
    <PageHeader>
      <template #title>Species</template><template #action>
        <LinkButton :href="route('creator.campaigns.species.create', { campaign: campaignStore.selectedCampaignId })"
          :icon="['fas', 'plus']">Add species
        </LinkButton>
      </template>
    </PageHeader>
    <EntityTable
      :headings="[new EntityTableHeading('Name', 'name', true), new EntityTableHeading('Description', 'description')]"
      :entities="species.data" kebab-menu-button-aria-context="Species"></EntityTable>
  </CreatorDefaultContentLayout>
</template>