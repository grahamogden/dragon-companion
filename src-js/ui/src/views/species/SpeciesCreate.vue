<script setup lang="ts">
import { useSpeciesStore } from '../../stores/species';
import router from '../../router';
import SpeciesForm from './SpeciesForm.vue';
import {type SpeciesEntityInterface} from '../../services/species/SpeciesEntityInterface';
import { useCampaignStore } from '../../stores';

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
    router.push({name: 'species.list'})
  } else {
    alert('Please select a campaign to save a new species')
  }
}
</script>

<template>
  <div class="Species-create">
    <h1>Create a Species</h1>
    <SpeciesForm @save-Species="createSpecies" />
  </div>
</template>