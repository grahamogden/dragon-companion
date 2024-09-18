<script setup lang="ts">
  import { ref } from 'vue';
  import router from '../../router';
  import CharacterForm from './CharacterForm.vue';
  import { type CharacterEntityInterface } from '../../services/character/CharacterEntityInterface';
  import { useCampaignStore, useCharacterStore } from '../../stores';
  import PageHeader from '../../Components/page-header/PageHeader.vue';
  import { CharacterEntity } from '../../services/character';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const characterStore = useCharacterStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const character = ref<CharacterEntityInterface>(new CharacterEntity())
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  function createCharacter(): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    characterStore.addCharacter(
      campaignId,
      character.value
    ).then(() => {
      router.push({ name: 'characters.list', params: { externalCampaignId: campaignId } })
        .then(() => {
          notificationStore.addSuccess('Successfully created character')
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
  <div class="character-create">
    <page-header>Create an Character</page-header>
    <character-form :character="character" :is-parent-loading="false" @save-Character="createCharacter" />
  </div>
</template>