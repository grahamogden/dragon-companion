<script setup lang="ts">
  import { useCampaignStore } from '../../../stores'
  import EntityTable from '../../../Components/entity-table/EntityTable.vue'
  import EntityTableHeading from '../../../Components/entity-table/interface/entity-table-heading';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
  import { Head } from '@inertiajs/vue3';
  import { PropType } from 'vue';
  import { PaginationInterface } from '../../../types/pagination';
  import { MonsterIndexEntityInterface } from '../../../types/entities/monster';

  const campaignStore = useCampaignStore()

  defineProps({
    monsters: Object as PropType<PaginationInterface<MonsterIndexEntityInterface>>
  })

  // let allMonsters: MonsterEntityInterface[] = []
  // fetchMonsters(campaignId)

  // function fetchMonsters(campaignId: number): void {
  //   isLoading.value = true
  //   monsterStore.getMonsters(campaignId).then((monsterRes: MonsterEntityInterface[]) => {
  //     if (monsterRes !== null) {
  //       allMonsters = monsterRes
  //     }
  //     isLoading.value = false
  //   });
  // }

  // function confirmDelete(campaignId: number, id: number): void {
  //   if (window.confirm('Are you sure you want to delete ' + id)) {
  //     notificationStore.removeAllNotifications()
  //     monsterStore.deleteMonster(campaignId, id).then(() => {
  //       notificationStore.addSuccess('Successfully deleted monster')
  //       fetchMonsters(campaignId)
  //     })
  //   }
  // }
</script>

<template>

  <Head title="Monsters" />
  <CreatorDefaultContentLayout>
    <PageHeaderWithLink
      :href="route('creator.campaigns.monsters.create', { campaign: campaignStore.selectedCampaignId })">
      <template #title>Monsters</template><template #link><font-awesome-icon :icon="['fas', 'plus']" fixed-width
          class="mr-2" />Add monster</template>
    </PageHeaderWithLink>
    <entity-table :headings="[new EntityTableHeading('name', true), new EntityTableHeading('description', false)]"
      :entities="monsters.data" kebab-menu-button-aria-context="Monster"></entity-table>
  </CreatorDefaultContentLayout>
</template>
