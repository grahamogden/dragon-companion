<script setup lang="ts">
  import { ref, provide } from 'vue';
  import { useSpeciesStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import SpeciesForm from './SpeciesForm.vue'
  import { type SpeciesEntityInterface } from '../../services/species/SpeciesEntityInterface';
  import PageHeader from '../../Components/page-header/PageHeader.vue';
  import { SpeciesEntity } from '../../services/species';
  import { useRoute } from 'vue-router';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const speciesStore = useSpeciesStore()
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  const route = useRoute()
  const speciesId = parseInt(route.params.speciesId as string)
  const species = ref<SpeciesEntityInterface>(new SpeciesEntity())

  speciesStore.getOneSpecies(campaignId, speciesId)
    .then((speciesRes) => {
      if (speciesRes !== null) {
        species.value = speciesRes
      }
      isLoading.value = false
    })

  function editSpecies(): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    speciesStore.updateSpecies(
      campaignId,
      species.value
    ).then(() => {
      router.push({ name: 'species.list', params: { externalCampaignId: campaignId } })
        .then(() => {
          notificationStore.addSuccess('Successfully updated species')
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
  <div class="species-edit">
    <page-header>Edit "{{ species.name ? species.name : 'Unknown' }}" Species</page-header>
    <species-form :species="species" :is-parent-loading="isLoading" @save-Species="editSpecies" />
  </div>
</template>