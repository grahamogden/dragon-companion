<script setup lang="ts">
  import { useSpeciesStore } from '../../stores/species';
  import router from '../../router';
  import SpeciesForm from './SpeciesForm.vue';
  import { type SpeciesEntityInterface } from '../../services/species/SpeciesEntityInterface';
  import { useCampaignStore } from '../../stores';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import { ref } from 'vue';
  import { SpeciesEntity } from '../../services/species';

  const speciesStore = useSpeciesStore()
  const campaignStore = useCampaignStore()
  const campaignId = campaignStore.selectedCampaignId!
  const species = ref<SpeciesEntityInterface>(new SpeciesEntity())

  function createSpecies(): void {
    speciesStore.addSpecies(
      campaignId,
      species.value
    ).then(() => {
      router.push({ name: 'species.list', params: { externalCampaignId: campaignId } })
    })
  }
</script>

<template>
  <div class="species-create">
    <page-header>Create a Species</page-header>
    <species-form :species="species" :is-parent-loading="false" @save-Species="createSpecies" />
  </div>
</template>