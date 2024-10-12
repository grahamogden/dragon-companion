<script setup lang="ts">
  import { PropType } from 'vue';
  import EntityTable from '../../../Components/entity-table/EntityTable.vue'
  import { ItemIndexEntityInterface } from '../../../types/entities/item'
  import EntityTableHeading from '../../../Components/entity-table/interface/entity-table-heading';
  import { Head } from '@inertiajs/vue3';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import { type PaginationInterface } from '../../../types/pagination/pagination.interface';
  import { useCampaignStore } from '../../../stores';
  import LinkButton from '../../../Components/buttons/LinkButton.vue';

  defineProps({
    items: Object as PropType<PaginationInterface<ItemIndexEntityInterface>>,
  })

  const campaignStore = useCampaignStore()

  // let allItems: ItemEntityInterface[] = []
  // fetchItems(campaignId)

  // function fetchItems(campaignId: number): void {
  //   isLoading.value = true
  //   itemStore.getItems(campaignId).then((itemRes: ItemEntityInterface[]) => {
  //     if (itemRes !== null) {
  //       allItems = itemRes
  //     }
  //     isLoading.value = false
  //   });
  // }

  // function confirmDelete(campaignId: number, id: number): void {
  //   if (window.confirm('Are you sure you want to delete ' + id)) {
  //     notificationStore.removeAllNotifications()
  //     itemStore.deleteItem(campaignId, id).then(() => {
  //       notificationStore.addSuccess('Successfully deleted item')
  //       fetchItems(campaignId)
  //     })
  //   }
  // }
</script>

<template>

  <Head title="Items" />
  <CreatorDefaultContentLayout>
    <PageHeader>
      <template #title>Items</template><template #action>
        <LinkButton :href="route('creator.campaigns.items.create', { campaign: campaignStore.selectedCampaignId })"
          :icon="['fas', 'plus']">Add item</LinkButton>
      </template>
    </PageHeader>
    <EntityTable
      :headings="[new EntityTableHeading('Name', 'name', true), new EntityTableHeading('Description', 'description', false)]"
      :entities="items.data" kebab-menu-button-aria-context="Item"></EntityTable>
  </CreatorDefaultContentLayout>
</template>
