<script setup lang="ts">
  import { ref } from 'vue';
  import { RouterLink } from 'vue-router'
  import { useSpeciesStore, useCampaignStore } from '../../stores'
  import KebabMenu from '../../components/dropdowns/kebab-menu/KebabMenu.vue'
  import { DropDownItemRouter, DropDownItemButton } from '../../components/interfaces/drop-down.item.interface';
  import type { SpeciesEntityInterface } from '../../services/species';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import EntityPage from '../../components/entity-page/EntityPage.vue';

  const speciesStore = useSpeciesStore()
  const campaignStore = useCampaignStore()
  const isLoading = ref(true)

  let allSpecies = ref<SpeciesEntityInterface[]>([])
  if (campaignStore.selectedCampaignId) {
    fetchSpecies(campaignStore.selectedCampaignId)
  }

  function fetchSpecies(campaignId: number): void {
    isLoading.value = true
    speciesStore.fetchSpecies(campaignId).then((species: SpeciesEntityInterface[]) => {
      if (species !== null) {
        allSpecies.value = species
      }
      isLoading.value = false
    });
  }

  async function confirmDelete(campaignId: number, id: number): Promise<void> {
    console.debug('Confirming delete for ' + id)
    if (window.confirm('Are you sure you want to delete ' + id)) {
      console.debug('Confirmed - attempting delete')
      await speciesStore.deleteSpecies(campaignId, id)
      // allSpecies.value = await speciesStore.fetchSpecies(campaignId)
      fetchSpecies(campaignId)
    }
  }

  function getLinks(campaignId: number, species: SpeciesEntityInterface): (DropDownItemRouter | DropDownItemButton)[] {
    return [
      new DropDownItemRouter(
        'Edit',
        { name: 'species.edit', params: { externalCampaignId: campaignId, speciesId: species.id } },
      ),
      new DropDownItemButton(
        'Delete',
        {
          func: confirmDelete,
          args: [campaignId, species.id],
        }
      )
    ]
  }
</script>

<template>
  <div class="species-list">
    <page-header link-text="Add species" :link-destination="{ name: 'species.add' }" >Species</page-header>
    <entity-page v-if="campaignStore.selectedCampaignId" v-model="isLoading">
      <template #content>
        <table class="entity-list-table">
          <thead>
            <tr>
              <th>Name</th>
              <th aria-label="Actions"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="species in allSpecies">
              <td><router-link :to="{ name: 'species.view', params: { externalCampaignId: campaignStore.selectedCampaignId, speciesId: species.id } }">{{
                  species.name
                  }}</router-link></td>
              <td class="action-cell w-fit">
                <KebabMenu :links="getLinks(campaignStore.selectedCampaignId, species)" :button-aria-context-name="'Species ' + species.name" />
              </td>
            </tr>
          </tbody>
        </table>
      </template>
      <template #loading-text>species</template>
    </entity-page>
  </div>
</template>
