<script setup lang="ts">
  import { PropType } from 'vue';
  import { useCampaignStore } from '../../../stores'
  import EntityTable from '../../../Components/entity-table/EntityTable.vue'
  import EntityTableHeading from '../../../Components/entity-table/interface/entity-table-heading';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import type { PaginationInterface } from '../../../types/pagination';
  import { CharacterIndexEntityInterface } from '../../../types/entities/character';
  import { Head } from '@inertiajs/vue3';
  import LinkButton from '../../../Components/buttons/LinkButton.vue';

  const campaignStore = useCampaignStore()

  defineProps({
    characters: Object as PropType<PaginationInterface<CharacterIndexEntityInterface>>,
  })

  // let allCharacters: CharacterEntityInterface[] = []
  // fetchCharacters(campaignId)

  // function fetchCharacters(campaignId: number): void {
  //   isLoading.value = true
  //   characterStore.getCharacters(campaignId).then((characterRes: CharacterEntityInterface[]) => {
  //     if (characterRes !== null) {
  //       allCharacters = characterRes
  //     }
  //     isLoading.value = false
  //   });
  // }

  // function confirmDelete(campaignId: number, id: number): void {
  //   if (window.confirm('Are you sure you want to delete ' + id)) {
  //     notificationStore.removeAllNotifications()
  //     characterStore.deleteCharacter(campaignId, id).then(() => {
  //       notificationStore.addSuccess('Successfully deleted character')
  //       fetchCharacters(campaignId)
  //     })
  //   }
  // }
</script>

<template>

  <Head title="Characters" />
  <CreatorDefaultContentLayout>
    <PageHeader>
      <template #title>Characters</template><template #action>
        <LinkButton :href="route('creator.campaigns.characters.create', { campaign: campaignStore.selectedCampaignId })"
          :icon="['fas', 'plus']">Add character</LinkButton>
      </template>
    </PageHeader>
    <entity-table :headings="[new EntityTableHeading('Name', 'name', true)]" :entities="characters.data"
      kebab-menu-button-aria-context="Character"></entity-table>
  </CreatorDefaultContentLayout>
</template>
