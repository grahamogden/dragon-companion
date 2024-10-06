<script setup lang="ts">
  import { PropType } from 'vue';
  import { useCampaignStore } from '../../../stores';
  import { type MonsterEntityInterface } from '../../../types/entities/monster/';
  import ContentGroup from '../../../Components/elements/ContentGroup.vue'
  import { Head } from '@inertiajs/vue3';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';
  import { MonsterSizeEnum } from '../../../types/entities/monster/monster-size.enum.ts';
  import { SpeciesEntityInterface } from '../../../types/entities/species/species.entity.interface.ts';

  defineProps({
    monster: { type: Object as PropType<MonsterEntityInterface>, required: true },
    species: { type: Object as PropType<SpeciesEntityInterface>, required: false },
  })

  const campaignStore = useCampaignStore()

  // monsterStore.getOneMonster(campaignId, monsterId).then((monsterRes) => {
  //   if (monsterRes !== null) {
  //     monster.value = monsterRes
  //   }
  //   isLoading.value = false
  // })
</script>

<template>

  <Head :title="monster.name + ' Monster'" />
  <CreatorDefaultContentLayout>
    <PageHeaderWithLink
      :href="route('creator.campaigns.monsters.edit', { campaign: campaignStore.selectedCampaignId, monster: monster.id })">
      <template #title>{{ monster.name + ` (CR: ` + (monster.challenge_rating !== null ? monster.challenge_rating :
        'unknown') + `)`
        }}</template><template #link><font-awesome-icon :icon="['fas', 'pencil']" fixed-width
          class="mr-2"></font-awesome-icon>Edit {{
            monster.name ? monster.name : 'Monster' }}</template>
    </PageHeaderWithLink>
    <ContentGroup><template #heading>Hit points</template><template #content>{{ monster.default_hit_points }} ({{
      monster.calculated_hit_points_dice_count }}d{{ monster.calculated_hit_points_dice_type }} + {{
          monster.calculated_hit_points_modifier }})</template>
    </ContentGroup>
    <ContentGroup><template #heading>Size</template><template #content>{{ MonsterSizeEnum[monster.size ??
      MonsterSizeEnum.Unknown]
        }}</template>
    </ContentGroup>
    <ContentGroup><template #heading>Description</template><template #content>{{ monster.description }}</template>
    </ContentGroup>

  </CreatorDefaultContentLayout>
</template>