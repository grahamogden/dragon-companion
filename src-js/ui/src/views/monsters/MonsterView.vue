<script setup lang="ts">
  import { ref } from 'vue';
  import { useCampaignStore, useMonsterStore } from '../../stores';
  import { MonsterEntity, type MonsterEntityInterface } from '../../services/monster';
  import PageHeader from '../../components/page-header/PageHeader.vue';
  import LoadingPage from '../../components/loading-page/LoadingPage.vue'
  import { useRoute } from 'vue-router';
  import ContentGroup from '../../components/elements/ContentGroup.vue'
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../components/page-header/interface';
  import { MonsterSizeEnum } from '../../services/monster/MonsterSizeEnum.ts'

  const monsterStore = useMonsterStore()
  const route = useRoute()
  const campaign = useCampaignStore()
  const campaignId = campaign.selectedCampaignId!
  const monsterId = parseInt(route.params.monsterId as string)
  let isLoading = ref(true)
  let monster = ref<MonsterEntityInterface>(new MonsterEntity())

  monsterStore.getOneMonster(campaignId, monsterId).then((monsterRes) => {
    if (monsterRes !== null) {
      monster.value = monsterRes
    }
    isLoading.value = false
  })
</script>

<template>
  <div class="monster-view">
    <page-header
      :link="new PageHeaderLink('Edit', { name: 'monsters.edit', params: { externalCampaignId: campaignId, monsterId: monsterId } }, PageHeaderLinkActionEnum.EDIT)">{{
        monster.name ? monster.name : 'Monster' }}</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
        <ContentGroup><template #heading>Hit points</template><template #content>{{ monster.default_hit_points }} ({{
        monster.calculated_hit_points_dice_count }}d{{ monster.calculated_hit_points_dice_type }} + {{
        monster.calculated_hit_points_modifier }})</template>
        </ContentGroup>
        <ContentGroup><template #heading>Size</template><template #content>{{ MonsterSizeEnum[monster.size ?? 0]
            }}</template>
        </ContentGroup>
        <ContentGroup><template #heading>Description</template><template #content>{{ monster.description }}</template>
        </ContentGroup>
      </template>
      <template #loading-text>monster</template>
    </loading-page>
  </div>
</template>