<script setup lang="ts">
  import { useSpeciesStore } from '../../stores/species';
  import router from '../../router';
  import SpeciesForm from './SpeciesForm.vue';
  import { type SpeciesEntityInterface } from '../../services/species/SpeciesEntityInterface';
  import { useCampaignStore } from '../../stores';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { ref, provide } from 'vue';
  import { SpeciesEntity } from '../../services/species';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const speciesStore = useSpeciesStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const species = ref<SpeciesEntityInterface>(new SpeciesEntity())
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  function createSpecies(): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    speciesStore.addSpecies(
      campaignId,
      species.value
    ).then(() => {
      router.push({ name: 'species.list', params: { externalCampaignId: campaignId } })
        .then(() => {
          notificationStore.addSuccess('Successfully created species')
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
  <div class="species-create">
    <page-header>Create a Species</page-header>
    <species-form :species="species" :is-parent-loading="false" @save-Species="createSpecies" />
  </div>
</template>