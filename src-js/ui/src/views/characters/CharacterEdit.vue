<script setup lang="ts">
  import { ref } from 'vue';
  import { useCharacterStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import CharacterForm from './CharacterForm.vue'
  import { type CharacterEntityInterface } from '../../services/character/CharacterEntityInterface';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { CharacterEntity } from '../../services/character';
  import { useRoute } from 'vue-router';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const characterStore = useCharacterStore()
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  const route = useRoute()
  const characterId = parseInt(route.params.characterId as string)
  const character = ref<CharacterEntityInterface>(new CharacterEntity())

  characterStore.getOneCharacter(campaignId, characterId)
    .then((characterRes) => {
      if (characterRes !== null) {
        character.value = characterRes
      }
      isLoading.value = false
    })

  function editCharacter(): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    characterStore.updateCharacter(
      campaignId,
      character.value
    ).then(() => {
      router.push({ name: 'characters.list', params: { externalCampaignId: campaignId } })
        .then(() => {
          notificationStore.addSuccess('Successfully updated character')
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
  <div class="character-edit">
    <page-header>Edit "{{ character.name ? character.name : 'Unknown' }}" Character</page-header>
    <character-form :character="character" :is-parent-loading="isLoading" @save-Character="editCharacter" />
  </div>
</template>