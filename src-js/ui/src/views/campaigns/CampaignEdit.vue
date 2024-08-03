<script setup lang="ts">
  import { ref, reactive } from 'vue';
  import { useCampaignStore } from '../../stores/campaign';
  import router from '../../router';
  import CampaignForm from './CampaignForm.vue'
  import { type CampaignEntityInterface } from '../../services/campaign/CampaignEntityInterface';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue';
  import { useNotificationStore } from '../../stores/notifications/notification-store';
  import { useValidationStore } from '../../stores/validation';
  import type ApplicationErrorInterface from '../../services/repository/errors/ApplicationErrorInterface';

  const isLoading = ref(true)
  const campaignStore = useCampaignStore()
  const params = router.currentRoute.value.params
  const campaignId = parseInt(params.externalCampaignId as string)
  let formData: CampaignEntityInterface | undefined = undefined
  const notificationStore = useNotificationStore()
  const validationStore = useValidationStore()

  // console.debug(campaignId)
  const campaign = campaignStore.getCampaignById(campaignId)
  // console.debug(campaign);
  if (campaign !== undefined) {
    formData = reactive(campaign)
    isLoading.value = false
  }

  function editCampaign(formData: CampaignEntityInterface): void {
    notificationStore.removeAllNotifications()
    validationStore.removeAllErrors()
    campaignStore.updateCampaign(
      {
        id: campaignId,
        name: formData.name,
        synopsis: formData.synopsis
      }
    ).then(() => {
      router.push({ name: 'campaigns.list' })
        .then(() => {
          notificationStore.addSuccess('Successfully updated campaign')
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
  <div class="campaign-edit">
    <!-- <div class="flex flex-row justify-between items-center mb-4">
      <h1>Editing - {{ campaign?.name ?? 'Unknown' }}</h1>
    </div> -->
    <page-header>{{ campaign?.name ?? 'Unknown' }}</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <CampaignForm :data="formData" @save-campaign="editCampaign" />
      </template>
      <template #loading-text>campaign</template>
    </loading-page>
  </div>
</template>