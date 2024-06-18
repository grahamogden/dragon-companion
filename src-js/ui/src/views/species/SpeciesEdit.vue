<script setup lang="ts">
  import { ref, reactive } from 'vue';
  import { useSpeciesStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import SpeciesForm from './SpeciesForm.vue'
  import { type SpeciesEntityInterface } from '../../services/species/SpeciesEntityInterface';

  const isLoading = ref(true)
  const speciesStore = useSpeciesStore()
  const campaignStore = useCampaignStore()

  const params = router.currentRoute.value.params
  console.debug(router.currentRoute.value)
  console.debug(router.currentRoute.value.params)
  const campaignId = parseInt(params.externalCampaignId as string)
  const speciesId = parseInt(params.id as string)
  let formData: SpeciesEntityInterface | undefined = undefined

  console.debug(speciesId)
  let species: SpeciesEntityInterface | null = null
  // if (campaignStore.selectedCampaignId) {
    species = await speciesStore.fetchOneSpecies(campaignId, speciesId)
  // }
  console.debug(species);
  if (species !== undefined && species !== null) {
    formData = reactive(species)
  }

  async function editSpecies(formData: SpeciesEntityInterface): Promise<void> {
    // if (campaignStore.selectedCampaignId) {
      await speciesStore.updateSpecies(
        campaignId,
        {
          id: speciesId,
          name: formData.name,
        }
      )
      console.debug('Editing Species')
      router.push({ name: 'species.list' })
    // }
    // alert('Please select a campaign before editing a species!')
  }
</script>

<template>
  <div class="Species-edit" v-if="isLoading">
    <h1>Edit "{{ species?.name ?? 'Unknown' }}" Species</h1>
    <SpeciesForm :data="formData" @save-Species="editSpecies" />
  </div>
</template>