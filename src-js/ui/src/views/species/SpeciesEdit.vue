<script setup lang="ts">
  import { ref, reactive } from 'vue';
  import { useSpeciesStore, useCampaignStore } from '../../stores';
  import router from '../../router';
  import SpeciesForm from './SpeciesForm.vue'
  import { type SpeciesEntityInterface } from '../../services/species/SpeciesEntityInterface';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import EntityPage from '../../components/entity-page/EntityPage.vue';
import { SpeciesEntity } from '../../services/species';

  const isLoading = ref(true)
  const speciesStore = useSpeciesStore()
  const campaignStore = useCampaignStore()

  const params = router.currentRoute.value.params
  const campaignId = parseInt(params.externalCampaignId as string)
  const speciesId = parseInt(params.speciesId as string)
  console.debug(campaignId)
  console.debug(speciesId)
  let formData = ref<SpeciesEntityInterface>(new SpeciesEntity())

  if (campaignStore.selectedCampaignId) {
    speciesStore.getOneSpecies(campaignId, speciesId)
    .then((species) => {
      if (species !== null) {
        formData.value.id = species.id
        formData.value.name = species.name
      }
      isLoading.value = false
    })
  }
  // if (species !== undefined && species !== null) {
  //   formData = reactive(species)
  // }

  async function editSpecies(formData: SpeciesEntityInterface): Promise<void> {
    if (campaignStore.selectedCampaignId) {
      await speciesStore.updateSpecies(
        campaignId,
        {
          id: speciesId,
          name: formData.name,
        }
      )
      // console.debug('Editing Species')
      router.push({ name: 'species.list' })
    }
    // alert('Please select a campaign before editing a species!')
  }
</script>

<template>
  <div class="species-edit">
    <page-header>Edit "{{ formData.name ? formData.name : 'Unknown' }}" Species</page-header>
    <entity-page v-model="isLoading">
      <template #content>
        <species-form :data="formData" @save-Species="editSpecies" />
      </template>
      <template #loading-text>species</template>
    </entity-page>
  </div>
</template>