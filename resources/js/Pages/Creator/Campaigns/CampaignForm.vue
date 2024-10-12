<script setup lang="ts">
  import TextArea from '../../../Components/Fields/TextArea.vue'
  import EntityButtonWrapper from '../../../Components/entity-button-wrapper/EntityButtonWrapper.vue'
  import { CampaignEntityInterface } from '../../../types/entities/campaign'
  import BaseInput from '../../../Components/Fields/BaseInput.vue'
  import { Head, useForm, usePage } from '@inertiajs/vue3'
  import { PropType } from 'vue';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';

  const props = defineProps({
    campaign: { type: Object as PropType<CampaignEntityInterface>, required: false }
  })

  const form = useForm({
    name: props.campaign?.name ?? '',
    synopsis: props.campaign?.synopsis ?? '',
  })

  const saveCampaign = () => {
    if (props.campaign) {
      form.put(route('creator.campaigns.update', { campaign: props.campaign.id }))
    } else {
      form.post(route('creator.campaigns.store'))
    }
  }
  const title = (props.campaign ? 'Edit ' + props.campaign.name : 'Create a') + ' Campaign'
</script>

<template>

  <Head :title="title" />
  <form @submit.prevent="saveCampaign">
    <CreatorDefaultContentLayout>
      <PageHeader><template #title>{{ title }}</template></PageHeader>
      <div class="w-full md:w-2/4">
        <BaseInput type="text" inputName="name" v-model:model="form.name" :error="form.errors.name"
          label="Campaign Name" :isRequired="true">
        </BaseInput>
      </div>
      <div class="w-full">
        <text-area inputName="synopsis" v-model:model="form.synopsis" :error="form.errors.synopsis"
          label="Synopsis of campaign" :length="1000"></text-area>
      </div>
      <EntityButtonWrapper :cancelDestination="route('creator.campaigns.index')" />
    </CreatorDefaultContentLayout>
  </form>
</template>
