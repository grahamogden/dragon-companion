<script setup lang="ts">
  import { ref } from 'vue';
  import { useSpeciesStore, useCampaignStore } from '../../stores'
  import type { SpeciesEntityInterface } from '../../services/species'
  import PageHeader from '../../components/page-header/PageHeader.vue'
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import EntityTable from '../../components/entity-table/EntityTable.vue'
  import EntityTableLink from '../../components/entity-table/interface/entity-table-link';
  import EntityTableHeading from '../../components/entity-table/interface/entity-table-heading';

  const speciesStore = useSpeciesStore()
  const campaignStore = useCampaignStore()
  const isLoading = ref(true)

  let allSpecies = ref<SpeciesEntityInterface[]>([])
  if (campaignStore.selectedCampaignId) {
    fetchSpecies(campaignStore.selectedCampaignId)
  }

  function fetchSpecies(campaignId: number): void {
    isLoading.value = true
    speciesStore.fetchSpecies(campaignId).then((species: SpeciesEntityInterface[]) => {
      if (species !== null) {
        allSpecies.value = species
      }
      isLoading.value = false
    });
  }

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      speciesStore.deleteSpecies(campaignId, id).then(() => {
        fetchSpecies(campaignId)
      })
    }
  }
</script>

<template>
  <div class="species-list">
    <page-header link-text="Add species" :link-destination="{ name: 'species.add' }">Species</page-header>
    <loading-page v-if="campaignStore.selectedCampaignId" v-model="isLoading">
      <template #content>
        <entity-table :headings="[new EntityTableHeading('name', true)]"
          :entities="allSpecies"
          :view-link="new EntityTableLink('species.view', 'speciesId')"
          :edit-link="new EntityTableLink('species.edit', 'speciesId')"
          :delete-confirmation-function="confirmDelete"
          kebab-menu-button-aria-context="Species"></entity-table>
      </template>
      <template #loading-text>species</template>
    </loading-page>
  </div>
</template>
