<script setup lang="ts">
  import { ref } from 'vue';
  import router from '../../router';
  import ItemForm from './ItemForm.vue';
  import { type ItemEntityInterface } from '../../services/item/ItemEntityInterface';
  import { useCampaignStore, useItemStore } from '../../stores';
  import PageHeader from '../../Components/page-header/PageHeader.vue';
  import { ItemEntity } from '../../services/item';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const itemStore = useItemStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const item = ref<ItemEntityInterface>(new ItemEntity())
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  function createItem(): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    itemStore.addItem(
      campaignId,
      item.value
    ).then(() => {
      router.push({ name: 'items.list', params: { externalCampaignId: campaignId } })
        .then(() => {
          notificationStore.addSuccess('Successfully created item')
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
  <div class="item-create">
    <page-header>Create an Item</page-header>
    <item-form :item="item" :is-parent-loading="false" @save-Item="createItem" />
  </div>
</template>