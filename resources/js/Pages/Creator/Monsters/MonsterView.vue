<script setup lang="ts">
  import { PropType } from 'vue';
  import { useCampaignStore } from '../../../stores';
  import { type MonsterEntityInterface } from '../../../types/entities/monster/';
  import ContentGroup from '../../../Components/elements/ContentGroup.vue'
  import { Head } from '@inertiajs/vue3';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import { MonsterSizeEnum } from '../../../types/entities/monster/monster-size.enum.ts';
  import { SpeciesEntityInterface } from '../../../types/entities/species/species.entity.interface.ts';
  import LinkButton from '../../../Components/buttons/LinkButton.vue';

  defineProps({
    monster: { type: Object as PropType<MonsterEntityInterface>, required: true },
    species: { type: Object as PropType<SpeciesEntityInterface>, required: false },
  })

  const campaignStore = useCampaignStore()
</script>

<template>

  <Head :title="monster.name + ' Monster'" />
  <CreatorDefaultContentLayout>
    <PageHeader>
      <template #title>{{ monster.name + ` (CR: ` + (monster.challenge_rating !== null ? monster.challenge_rating :
        'unknown') + `)`
        }}</template><template #action>
        <LinkButton
          :href="route('creator.campaigns.monsters.edit', { campaign: campaignStore.selectedCampaignId, monster: monster.id })"
          :icon="['fas', 'pencil']">Edit {{
            monster.name ? monster.name : 'Monster' }}</LinkButton>
      </template>
    </PageHeader>
    <div class="grid grid-cols-2 md:grid-cols-4">
      <ContentGroup><template #heading>Hit points</template><template #content>{{ monster.default_hit_points }} ({{
        monster.calculated_hit_points_dice_count }}d{{ monster.calculated_hit_points_dice_type }} + {{
            monster.calculated_hit_points_modifier }})</template>
      </ContentGroup>
      <ContentGroup><template #heading>Armour class</template><template #content>{{ monster.armour_class }}</template>
      </ContentGroup>
      <ContentGroup><template #heading>Speed</template><template #content>{{ monster.speed }}</template>
      </ContentGroup>
      <ContentGroup><template #heading>Size</template><template #content>{{ MonsterSizeEnum[monster.size ??
        MonsterSizeEnum.Unknown]
          }}</template>
      </ContentGroup>
    </div>
    <ContentGroup><template #heading>Description</template><template #content>{{ monster.description }}</template>
    </ContentGroup>
  </CreatorDefaultContentLayout>
</template>