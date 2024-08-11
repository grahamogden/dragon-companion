<script setup lang="ts">
  import { ref } from 'vue';
  import { useCampaignStore, useItemStore } from '../../stores';
  import { ItemEntity, type ItemEntityInterface } from '../../services/item';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import { useRoute } from 'vue-router';
  import ContentGroup from '../../components/elements/ContentGroup.vue'
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../components/page-header/interface';

  const itemStore = useItemStore()
  const route = useRoute()
  const campaign = useCampaignStore()
  const campaignId = campaign.selectedCampaignId!
  const itemId = parseInt(route.params.itemId as string)
  let isLoading = ref(true)
  let item = ref<ItemEntityInterface>(new ItemEntity())

  itemStore.getOneItem(campaignId, itemId).then((itemRes) => {
    if (itemRes !== null) {
      item.value = itemRes
    }
    isLoading.value = false
  })
</script>

<template>
  <div class="item-view">
    <page-header
      :link="new PageHeaderLink('Edit', { name: 'items.edit', params: { externalCampaignId: campaignId, itemId: itemId } }, PageHeaderLinkActionEnum.EDIT)">{{
        item.name ? item.name : 'Item' }}</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <ContentGroup><template #content>{{ item.description }}</template></ContentGroup>
      </template>
      <template #loading-text>item</template>
    </loading-page>
  </div>
</template>