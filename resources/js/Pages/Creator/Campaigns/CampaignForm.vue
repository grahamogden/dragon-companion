<script setup lang="ts">
  import TextArea from '../../../Components/Fields/TextArea.vue'
  import EntityButtonWrapper from '../../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
  import { CampaignEntityInterface, type NewCampaignEntityInterface, CampaignEntity } from '../../../types/entities/campaign'
  import LoadingPage from '../../../Components/loading-page/LoadingPage.vue';
  import BaseInput from '../../../Components/Fields/BaseInput.vue'
  import { Head, useForm, usePage } from '@inertiajs/vue3'
  import { PropType } from 'vue';
  import { User } from '../../../types';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';

  // const props = defineProps<{
  //     data?: CampaignEntityInterface
  //     isLoading?: boolean
  // }>()

  // let campaign: NewCampaignEntityInterface = new CampaignEntity(
  //     props.data?.id,
  //     props.data?.name,
  //     props.data?.synopsis
  // );

  // if (props.data) {
  //     campaign = props.data
  // }

  // const props = defineProps({ campaign: Object as PropType<CampaignEntityInterface | null>, auth: Object as PropType<User> })

  const form = useForm({
    name: '',
    synopsis: '',
  })

  const saveCampaign = () => {
    //   notificationStore.removeAllNotifications()
    //   validationStore.removeAllErrors()

    //   campaignStore.addCampaign(
    //     {
    //       name: formData.name,
    //       synopsis: formData.synopsis
    //     }
    //   ).then(() => {
    //     router.push({ name: 'campaigns.list' })
    //       .then(() => {
    //         notificationStore.addSuccess('Successfully created campaign')
    //       })
    //   })
    //     .catch((error: ApplicationErrorInterface) => {
    //       console.debug(error)
    //       notificationStore.addError(error.message)
    //       if (error.errors) {
    //         validationStore.addErrors(error.errors)
    //       }
    //     })
    console.debug(usePage().props.auth);
    form.post(route('creator.campaigns.store'))
  }
</script>

<template>

  <Head title="Create a Campaign" />
  <form @submit.prevent="saveCampaign">
    <CreatorDefaultContentLayout>
      <PageHeader>Create a Campaign</PageHeader>
      <div class="w-full md:w-2/4">
        <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name"
          label="Campaign Name" :require="true">
        </BaseInput>
      </div>
      <div class="w-full">
        <text-area inputName="synopsis" v-model:model="form.synopsis" :error="form.errors.synopsis"
          label="Synopsis of campaign" :length="1000" :require="true"></text-area>
      </div>
      <EntityButtonWrapper :cancelDestination="route('creator.campaigns.index')" />
    </CreatorDefaultContentLayout>
  </form>
</template>
