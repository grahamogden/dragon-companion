<script setup lang="ts">
  import { ref } from 'vue';
  import { useCampaignStore, useSpeciesStore } from '../../stores';
  import { SpeciesEntity, type SpeciesEntityInterface } from '../../services/species';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import { useRoute } from 'vue-router';
  import ContentGroup from '../../components/elements/ContentGroup.vue'
  import { PageHeaderLink, type PageHeaderLinkActionEnum } from '../../components/page-header/interface';

  const speciesStore = useSpeciesStore()
  const route = useRoute()
  const campaign = useCampaignStore()
  const campaignId = campaign.selectedCampaignId!
  const speciesId = parseInt(route.params.speciesId as string)
  let isLoading = ref(true)
  let species = ref<SpeciesEntityInterface>(new SpeciesEntity())

  speciesStore.getOneSpecies(campaignId, speciesId).then((speciesRes) => {
    if (speciesRes !== null) {
      species.value = speciesRes
    }
    isLoading.value = false
  })
</script>

<template>
  <div class="species-view">
    <page-header
      :link="new PageHeaderLink('Edit', { name: 'species.edit', params: { externalCampaignId: campaignId, speciesId: speciesId } }, PageHeaderLinkActionEnum.EDIT)">{{
        species.name ? species.name : 'Species' }}</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <!-- <content-group><template #content>{{ species.name }}</template></content-group> -->
      </template>
      <template #loading-text>species</template>
    </loading-page>
  </div>
</template>