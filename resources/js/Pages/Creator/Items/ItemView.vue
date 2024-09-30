<script setup lang="ts">
  import { PropType } from 'vue';
  import { ItemEntity } from '../../../types/entities/item';
  import ContentGroup from '../../../Components/elements/ContentGroup.vue'
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
  import { useCampaignStore } from '../../../stores';

  defineProps({
    item: { type: Object as PropType<ItemEntity>, required: true }
  })
  const campaignStore = useCampaignStore()
</script>

<template>
  <CreatorDefaultContentLayout>
    <PageHeaderWithLink
      :href="route('creator.campaigns.items.edit', { campaign: campaignStore.selectedCampaignId, item: item.id })">
      <template #title>{{ item.name }}</template><template #link><font-awesome-icon :icon="['fas', 'pencil']"
          fixed-width class="mr-2"></font-awesome-icon>Edit {{
            item.name ? item.name : 'Item' }}</template>
    </PageHeaderWithLink>
    <ContentGroup><template #content>{{ item.description }}</template></ContentGroup>
  </CreatorDefaultContentLayout>
</template>