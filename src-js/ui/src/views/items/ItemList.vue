<script setup lang="ts">
  import { ref } from 'vue';
  import { useItemStore, useCampaignStore, useNotificationStore } from '../../stores'
  import type { ItemEntityInterface } from '../../services/item'
  import PageHeader from '../../components/page-header/PageHeader.vue'
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import EntityTable from '../../components/entity-table/EntityTable.vue'
  import EntityTableLink from '../../components/entity-table/interface/entity-table-link';
  import EntityTableHeading from '../../components/entity-table/interface/entity-table-heading';
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../components/page-header/interface';

  const notificationStore = useNotificationStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const itemStore = useItemStore()
  const isLoading = ref(true)

  let allItems: ItemEntityInterface[] = []
  fetchItems(campaignId)

  function fetchItems(campaignId: number): void {
    isLoading.value = true
    itemStore.getItems(campaignId).then((itemRes: ItemEntityInterface[]) => {
      if (itemRes !== null) {
        allItems = itemRes
      }
      isLoading.value = false
    });
  }

  function confirmDelete(campaignId: number, id: number): void {
    if (window.confirm('Are you sure you want to delete ' + id)) {
      notificationStore.removeAllNotifications()
      itemStore.deleteItem(campaignId, id).then(() => {
        notificationStore.addSuccess('Successfully deleted item')
        fetchItems(campaignId)
      })
    }
  }
</script>

<template>
  <div class="item-list">
    <page-header
      :link="new PageHeaderLink('Add item', { name: 'items.add' }, PageHeaderLinkActionEnum.ADD)">Items</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <entity-table :headings="[new EntityTableHeading('name', true), new EntityTableHeading('description', false)]"
          :entities="allItems" :view-link="new EntityTableLink('items.view', 'itemId')"
          :edit-link="new EntityTableLink('items.edit', 'itemId')" :delete-confirmation-function="confirmDelete"
          kebab-menu-button-aria-context="Item"></entity-table>
      </template>
      <template #loading-text>item</template>
    </loading-page>
  </div>
</template>
