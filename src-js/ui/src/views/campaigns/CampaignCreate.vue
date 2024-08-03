<script setup lang="ts">
  import { useCampaignStore } from '../../stores/campaign';
  import router from '../../router';
  import CampaignForm from './CampaignForm.vue';
  import { type CampaignEntityInterface } from '../../services/campaign/CampaignEntityInterface';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { useNotificationStore } from '../../stores/notifications';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface'

  const campaignStore = useCampaignStore()
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  function createCampaign(formData: CampaignEntityInterface): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()

    campaignStore.addCampaign(
      {
        name: formData.name,
        synopsis: formData.synopsis
      }
    ).then(() => {
      router.push({ name: 'campaigns.list' })
        .then(() => {
          notificationStore.addSuccess('Successfully created campaign')
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
  <div class="campaign-create">
    <page-header>Create a Campaign</page-header>
    <campaign-form @save-campaign="createCampaign"></campaign-form>
  </div>
</template>