<script setup lang="ts">
  import { ref } from 'vue';
  import { useSpeciesStore, useCampaignStore, useNotificationStore } from '../../stores'
  import type { SpeciesEntityInterface } from '../../services/species'
  import PageHeader from '../../components/page-header/PageHeader.vue'
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import EntityTable from '../../components/entity-table/EntityTable.vue'
  import EntityTableLink from '../../components/entity-table/interface/entity-table-link';
  import EntityTableHeading from '../../components/entity-table/interface/entity-table-heading';
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../components/page-header/interface';

  const notificationStore = useNotificationStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const speciesStore = useSpeciesStore()
  const isLoading = ref(true)

  let allSpecies: SpeciesEntityInterface[] = []
  fetchSpecies(campaignId)

  function fetchSpecies(campaignId: number): void {
    isLoading.value = true
    speciesStore.fetchSpecies(campaignId).then((speciesRes: SpeciesEntityInterface[]) => {
      if (speciesRes !== null) {
        allSpecies = speciesRes
      }
      isLoading.value = false
    });
  }

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      notificationStore.removeAllNotifications()
      speciesStore.deleteSpecies(campaignId, id).then(() => {
        notificationStore.addSuccess('Successfully deleted species')
        fetchSpecies(campaignId)
      })
    }
  }
</script>

<template>
  <div class="species-list">
    <page-header
      :link="new PageHeaderLink('Add species', { name: 'species.add' }, PageHeaderLinkActionEnum.ADD)">Species</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <entity-table :headings="[new EntityTableHeading('name', true)]" :entities="allSpecies"
          :view-link="new EntityTableLink('species.view', 'speciesId')"
          :edit-link="new EntityTableLink('species.edit', 'speciesId')" :delete-confirmation-function="confirmDelete"
          kebab-menu-button-aria-context="Species"></entity-table>
      </template>
      <template #loading-text>species</template>
    </loading-page>
  </div>
</template>
