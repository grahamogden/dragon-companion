<script setup lang="ts">
  import { PropType } from 'vue';
  import { useCampaignStore } from '../../../stores'
  import EntityTable from '../../../Components/entity-table/EntityTable.vue'
  import EntityTableHeading from '../../../Components/entity-table/interface/entity-table-heading';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
  import type { PaginationInterface } from '../../../types/pagination';
  import { CharacterIndexEntityInterface } from '../../../types/entities/character';
  import { Head } from '@inertiajs/vue3';

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
    <PageHeaderWithLink
      :href="route('creator.campaigns.characters.create', { campaign: campaignStore.selectedCampaignId })">
      <template #title>Characters</template><template #link><font-awesome-icon :icon="['fas', 'plus']" fixed-width
          class="mr-2" />Add character</template>
    </PageHeaderWithLink>
    <entity-table :headings="[new EntityTableHeading('name', true)]" :entities="characters.data"
      kebab-menu-button-aria-context="Character"></entity-table>
  </CreatorDefaultContentLayout>
</template>
