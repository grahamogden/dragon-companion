<script setup lang="ts">
  import { ref } from 'vue';
  import router from '../../router';
  import MonsterForm from './MonsterForm.vue';
  import { type MonsterEntityInterface } from '../../services/monster/MonsterEntityInterface';
  import { useCampaignStore, useMonsterStore } from '../../stores';
  import PageHeader from '../../Components/page-header/PageHeader.vue';
  import { MonsterEntity } from '../../services/monster';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const monsterStore = useMonsterStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const monster = ref<MonsterEntityInterface>(new MonsterEntity())
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  function createMonster(): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    monsterStore.addMonster(
      campaignId,
      monster.value
    ).then(() => {
      router.push({ name: 'monsters.list', params: { externalCampaignId: campaignId } })
        .then(() => {
          notificationStore.addSuccess('Successfully created monster')
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
  <div class="monster-create">
    <page-header>Create an Monster</page-header>
    <monster-form :monster="monster" :is-parent-loading="false" @save-Monster="createMonster" />
  </div>
</template>