<script setup lang="ts">
  import { ref } from 'vue';
  import { useSpeciesStore } from '../../stores';
  import router from '../../router';
  import { SpeciesEntity, type SpeciesEntityInterface } from '../../services/species';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import EntityPage from '../../components/entity-page/EntityPage.vue'

  const speciesStore = useSpeciesStore()
  const params = router.currentRoute.value.params
  // console.debug(router.currentRoute.value)
  // console.debug(router.currentRoute.value.params)
  const campaignId = parseInt(params.externalCampaignId as string)
  const speciesId = parseInt(params.speciesId as string)
  let isLoading = ref(true)
  let formData = ref<SpeciesEntityInterface>(new SpeciesEntity())

  speciesStore.getOneSpecies(campaignId, speciesId).then((species) => {
    // console.debug(species)
    if (species !== null) {
      formData.value.id = species.id
      formData.value.name = species.name
    }
    isLoading.value = false
  })
</script>

<template>
  <div class="species-view">
    <page-header link-text="Edit" :link-destination="{ name: 'species.edit', params: { externalCampaignId: campaignId, speciesId: speciesId } }">{{ formData.name ? formData.name : 'Species' }}</page-header>
    <entity-page v-model="isLoading">
      <template #content>
        <div>{{ formData.name }}</div>
      </template>
      <template #loading-text>species</template>
    </entity-page>
  </div>
</template>