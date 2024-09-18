<script setup lang="ts">
  import { ref } from 'vue';
  import { useMonsterStore, useCampaignStore, useNotificationStore } from '../../stores'
  import type { MonsterEntityInterface } from '../../services/monster'
  import PageHeader from '../../Components/page-header/PageHeader.vue'
  import LoadingPage from '../../Components/loading-page/LoadingPage.vue'
  import EntityTable from '../../Components/entity-table/EntityTable.vue'
  import EntityTableLink from '../../Components/entity-table/interface/entity-table-link';
  import EntityTableHeading from '../../Components/entity-table/interface/entity-table-heading';
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../Components/page-header/interface';

  const notificationStore = useNotificationStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const monsterStore = useMonsterStore()
  const isLoading = ref(true)

  let allMonsters: MonsterEntityInterface[] = []
  fetchMonsters(campaignId)

  function fetchMonsters(campaignId: number): void {
    isLoading.value = true
    monsterStore.getMonsters(campaignId).then((monsterRes: MonsterEntityInterface[]) => {
      if (monsterRes !== null) {
        allMonsters = monsterRes
      }
      isLoading.value = false
    });
  }

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      notificationStore.removeAllNotifications()
      monsterStore.deleteMonster(campaignId, id).then(() => {
        notificationStore.addSuccess('Successfully deleted monster')
        fetchMonsters(campaignId)
      })
    }
  }
</script>

<template>
  <div class="monster-list">
    <page-header
      :link="new PageHeaderLink('Add monster', { name: 'monsters.add' }, PageHeaderLinkActionEnum.ADD)">Monsters</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <entity-table :headings="[new EntityTableHeading('name', true), new EntityTableHeading('description', false)]"
          :entities="allMonsters" :view-link="new EntityTableLink('monsters.view', 'monsterId')"
          :edit-link="new EntityTableLink('monsters.edit', 'monsterId')" :delete-confirmation-function="confirmDelete"
          kebab-menu-button-aria-context="Monster"></entity-table>
      </template>
      <template #loading-text>monster</template>
    </loading-page>
  </div>
</template>
