<script setup lang="ts">
  import { PropType } from 'vue';
  import EntityTable from '../../../Components/entity-table/EntityTable.vue'
  import { ItemIndexEntityInterface } from '../../../types/entities/item'
  import EntityTableHeading from '../../../Components/entity-table/interface/entity-table-heading';
  import { Head } from '@inertiajs/vue3';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
  import { type PaginationInterface } from '../../../types/pagination/pagination.interface';
  import { useCampaignStore } from '../../../stores';

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
    <PageHeaderWithLink :href="route('creator.campaigns.items.create', { campaign: campaignStore.selectedCampaignId })">
      <template #title>Items</template><template #link><font-awesome-icon :icon="['fas', 'plus']" fixed-width
          class="mr-2" />Add item</template>
    </PageHeaderWithLink>
    <EntityTable :headings="[new EntityTableHeading('name', true), new EntityTableHeading('description', false)]"
      :entities="items.data" kebab-menu-button-aria-context="Item"></EntityTable>
  </CreatorDefaultContentLayout>
</template>
