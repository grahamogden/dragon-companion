<script setup lang="ts">
  import { ref } from 'vue';
  import { useCharacterStore, useCampaignStore, useNotificationStore } from '../../stores'
  import type { CharacterEntityInterface } from '../../services/character'
  import PageHeader from '../../Components/page-header/PageHeader.vue'
  import LoadingPage from '../../Components/loading-page/LoadingPage.vue'
  import EntityTable from '../../Components/entity-table/EntityTable.vue'
  import EntityTableLink from '../../Components/entity-table/interface/entity-table-link';
  import EntityTableHeading from '../../Components/entity-table/interface/entity-table-heading';
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../Components/page-header/interface';

  const notificationStore = useNotificationStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const characterStore = useCharacterStore()
  const isLoading = ref(true)

  let allCharacters: CharacterEntityInterface[] = []
  fetchCharacters(campaignId)

  function fetchCharacters(campaignId: number): void {
    isLoading.value = true
    characterStore.getCharacters(campaignId).then((characterRes: CharacterEntityInterface[]) => {
      if (characterRes !== null) {
        allCharacters = characterRes
      }
      isLoading.value = false
    });
  }

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      notificationStore.removeAllNotifications()
      characterStore.deleteCharacter(campaignId, id).then(() => {
        notificationStore.addSuccess('Successfully deleted character')
        fetchCharacters(campaignId)
      })
    }
  }
</script>

<template>
  <div class="character-list">
    <page-header
      :link="new PageHeaderLink('Add character', { name: 'characters.add' }, PageHeaderLinkActionEnum.ADD)">Characters</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <entity-table :headings="[new EntityTableHeading('name', true), new EntityTableHeading('species', false)]"
          :entities="allCharacters" :view-link="new EntityTableLink('characters.view', 'characterId')"
          :edit-link="new EntityTableLink('characters.edit', 'characterId')"
          :delete-confirmation-function="confirmDelete" kebab-menu-button-aria-context="Character"></entity-table>
      </template>
      <template #loading-text>character</template>
    </loading-page>
  </div>
</template>
