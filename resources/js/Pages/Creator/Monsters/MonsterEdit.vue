<script setup lang="ts">
  import { ref } from 'vue';
  import { useMonsterStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import MonsterForm from './MonsterForm.vue'
  import { type MonsterEntityInterface } from '../../services/monster/MonsterEntityInterface';
  import PageHeader from '../../Components/page-header/PageHeader.vue';
  import { MonsterEntity } from '../../services/monster';
  import { useRoute } from 'vue-router';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const monsterStore = useMonsterStore()
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  const route = useRoute()
  const monsterId = parseInt(route.params.monsterId as string)
  const monster = ref<MonsterEntityInterface>(new MonsterEntity())

  monsterStore.getOneMonster(campaignId, monsterId)
    .then((monsterRes) => {
      if (monsterRes !== null) {
        monster.value = monsterRes
      }
      isLoading.value = false
    })

  function editMonster(): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    monsterStore.updateMonster(
      campaignId,
      monster.value
    ).then(() => {
      router.push({ name: 'monsters.list', params: { externalCampaignId: campaignId } })
        .then(() => {
          notificationStore.addSuccess('Successfully updated monster')
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
  <div class="monster-edit">
    <page-header>Edit "{{ monster.name ? monster.name : 'Unknown' }}" Monster</page-header>
    <monster-form :monster="monster" :is-parent-loading="isLoading" @save-Monster="editMonster" />
  </div>
</template>