<script setup lang="ts">
  import { PropType } from 'vue';
  import { ItemEntity } from '../../../types/entities/item';
  import ContentGroup from '../../../Components/elements/ContentGroup.vue'
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import { useCampaignStore } from '../../../stores';
  import { Head } from '@inertiajs/vue3';
  import LinkButton from '../../../Components/buttons/LinkButton.vue';

  defineProps({
    item: { type: Object as PropType<ItemEntity>, required: true }
  })
  const campaignStore = useCampaignStore()
</script>

<template>

  <Head :title="item.name + ' Item'" />
  <CreatorDefaultContentLayout>
    <PageHeader>
      <template #title>{{ item.name }}</template><template #action>
        <LinkButton
          :href="route('creator.campaigns.items.edit', { campaign: campaignStore.selectedCampaignId, item: item.id })"
          :icon="['fas', 'pencil']">Edit {{
            item.name ? item.name : 'Item' }}</LinkButton>
      </template>
    </PageHeader>
    <ContentGroup><template #content>{{ item.description }}</template></ContentGroup>
  </CreatorDefaultContentLayout>
</template>