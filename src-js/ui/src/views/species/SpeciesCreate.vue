<script setup lang="ts">
  import { useSpeciesStore } from '../../stores/species';
  import router from '../../router';
  import SpeciesForm from './SpeciesForm.vue';
  import { type SpeciesEntityInterface } from '../../services/species/SpeciesEntityInterface';
  import { useCampaignStore } from '../../stores';
  import PageHeader from '../../components/page-header/PageHeader.vue';

  const speciesStore = useSpeciesStore()
  const campaignStore = useCampaignStore()

  async function createSpecies(formData: SpeciesEntityInterface): Promise<void> {
    if (campaignStore.selectedCampaignId) {
      await speciesStore.addSpecies(
        campaignStore.selectedCampaignId,
        {
          name: formData.name,
        }
      )
      router.push({ name: 'species.list', params: { externalCampaignId: campaignStore.selectedCampaignId } })
    } else {
      alert('Please select a campaign to save a new species')
    }
  }
</script>

<template>
  <div class="species-create">
    <page-header>Create a Species</page-header>
    <SpeciesForm @save-Species="createSpecies" />
  </div>
</template>