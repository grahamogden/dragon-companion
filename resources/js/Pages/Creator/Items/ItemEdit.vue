<script setup lang="ts">
  import { ref } from 'vue';
  import { useItemStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import ItemForm from './ItemForm.vue'
  import { type ItemEntityInterface } from '../../services/item/ItemEntityInterface';
  import PageHeader from '../../Components/page-header/PageHeader.vue';
  import { ItemEntity } from '../../services/item';
  import { useRoute } from 'vue-router';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const itemStore = useItemStore()
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  const route = useRoute()
  const itemId = parseInt(route.params.itemId as string)
  const item = ref<ItemEntityInterface>(new ItemEntity())

  itemStore.getOneItem(campaignId, itemId)
    .then((itemRes) => {
      if (itemRes !== null) {
        item.value = itemRes
      }
      isLoading.value = false
    })

  function editItem(): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    itemStore.updateItem(
      campaignId,
      item.value
    ).then(() => {
      router.push({ name: 'items.list', params: { externalCampaignId: campaignId } })
        .then(() => {
          notificationStore.addSuccess('Successfully updated item')
        })
    })
      .catch((error: ApplicationErrorInterface) => {
        console.debug(error)
        notificationStore.addError(error.message)
        if (error.errors) {
          validationStore.addErrors(error.errors)
        }
      })
  }
</script>

<template>
  <div class="item-edit">
    <page-header>Edit "{{ item.name ? item.name : 'Unknown' }}" Item</page-header>
    <item-form :item="item" :is-parent-loading="isLoading" @save-Item="editItem" />
  </div>
</template>