<script setup lang="ts">
  import { ref } from 'vue';
  import { RouterLink } from 'vue-router'
  import { useSpeciesStore, useCampaignStore } from '../../stores'
  import KebabMenu from '../../components/dropdowns/kebab-menu/KebabMenu.vue'
  import { DropDownItemRouter, DropDownItemButton } from '../../components/interfaces/drop-down.item.interface';
  import type { SpeciesEntityInterface } from '../../services/species';

  const speciesStore = useSpeciesStore()
  const campaignStore = useCampaignStore()

  let allSpecies = ref<SpeciesEntityInterface[]>([])
  if (campaignStore.selectedCampaignId) {
    allSpecies.value = await speciesStore.fetchSpecies(campaignStore.selectedCampaignId);
  }

  async function confirmDelete(campaignId: number, id: number) {
    console.debug('Confirming delete for ' + id)
    if (window.confirm('Are you sure you want to delete ' + id)) {
      console.debug('Confirmed - attempting delete')
      await speciesStore.deleteSpecies(campaignId, id)
      allSpecies.value = await speciesStore.fetchSpecies(campaignId)
    }
  }

  function getLinks(campaignId: number, species: SpeciesEntityInterface): (DropDownItemRouter | DropDownItemButton)[] {
    return [
      new DropDownItemRouter(
        'Edit',
        { name: 'species.edit', params: { externalCampaignId: campaignId, id: species.id } },
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
  <h1>Species</h1>
  <div class="mb-4">
    <router-link :to="{ name: 'species.add' }" class="primary-button">Add species</router-link>
  </div>
  <div v-if="campaignStore.selectedCampaignId">
    <table class="entity-list-table">
      <thead>
        <tr>
          <th>Name</th>
          <th aria-label="Actions"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="species in allSpecies">
          <td><router-link :to="{ name: 'species.view', params: { externalCampaignId: campaignStore.selectedCampaignId, id: species.id } }">{{
              species.name
              }}</router-link></td>
          <td class="action-cell w-fit">
            <KebabMenu :links="getLinks(campaignStore.selectedCampaignId, species)" :button-aria-context-name="'Species ' + species.name" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
