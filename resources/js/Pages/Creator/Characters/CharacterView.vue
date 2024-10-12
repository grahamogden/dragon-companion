<script setup lang="ts">
  import { PropType } from 'vue';
  import { useCampaignStore } from '../../../stores';
  import { type CharacterEntityInterface } from '../../../types/entities/character';
  import ContentGroup from '../../../Components/elements/ContentGroup.vue'
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import { SpeciesEntityInterface } from '../../../types/entities/species';
  import LinkButton from '../../../Components/buttons/LinkButton.vue';

  defineProps({
    character: { type: Object as PropType<CharacterEntityInterface>, required: true },
    species: { type: Object as PropType<SpeciesEntityInterface>, required: false },
  })

  const campaignStore = useCampaignStore()
</script>

<template>

  <Head :title="character.name + ' Character'" />
  <CreatorDefaultContentLayout>
    <PageHeader>
      <template #title>{{ character.name }}</template><template #action>
        <LinkButton
          :href="route('creator.campaigns.characters.edit', { campaign: campaignStore.selectedCampaignId, character: character.id })"
          :icon="['fas', 'pencil']">Edit {{
            character.name ? character.name : 'Character' }}</LinkButton>
      </template>
    </PageHeader>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6">
      <ContentGroup><template #heading>Max hit points</template><template #content>{{
        character.max_hit_points
          }}</template></ContentGroup>
      <ContentGroup><template #heading>Armour class</template><template #content>{{
        character.armour_class
          }}</template></ContentGroup>
      <ContentGroup><template #heading>Dexterity modifier</template><template #content>{{
        character.dexterity_modifier }}</template></ContentGroup>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6">
      <ContentGroup><template #heading>Age</template><template #content>{{
        character.age
          }}</template></ContentGroup>
      <ContentGroup><template #heading>Species</template><template #content>{{ character?.species?.name ?? 'Not set'
          }}</template>
      </ContentGroup>
    </div>
    <ContentGroup><template #heading>Appearance</template><template #content>{{ character.appearance }}</template>
    </ContentGroup>
    <ContentGroup><template #heading>Notes</template><template #content>{{ character.notes }}</template>
    </ContentGroup>
  </CreatorDefaultContentLayout>
</template>