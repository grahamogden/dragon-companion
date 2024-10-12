<script setup lang="ts">
  import { useCampaignStore } from '../../../stores'
  import EntityTable from '../../../Components/entity-table/EntityTable.vue'
  import EntityTableHeading from '../../../Components/entity-table/interface/entity-table-heading';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import { Head } from '@inertiajs/vue3';
  import { PropType } from 'vue';
  import { PaginationInterface } from '../../../types/pagination';
  import { MonsterIndexEntityInterface } from '../../../types/entities/monster';
  import LinkButton from '../../../Components/buttons/LinkButton.vue';

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
    <PageHeader>
      <template #title>Monsters</template>
      <template #action>
        <LinkButton :href="route('creator.campaigns.monsters.create', { campaign: campaignStore.selectedCampaignId })"
          :icon="['fas', 'plus']">Add monster</LinkButton>
      </template>
    </PageHeader>
    <entity-table
      :headings="[new EntityTableHeading('Name', 'name', true), new EntityTableHeading('Description', 'description', false)]"
      :entities="monsters.data" kebab-menu-button-aria-context="Monster"></entity-table>
  </CreatorDefaultContentLayout>
</template>
