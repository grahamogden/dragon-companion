<script setup lang="ts">
  import { PropType, ref } from 'vue';
  import { useCampaignStore } from '../../../stores';
  import { CharacterEntity, type CharacterEntityInterface } from '../../../types/entities/character';
  import PageHeader from '../../../Components/page-header/PageHeader.vue';
  import LoadingPage from '../../../Components/loading-page/LoadingPage.vue'
  import ContentGroup from '../../../Components/elements/ContentGroup.vue'
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../../Components/page-header/interface';
  import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import PageHeaderWithLink from '../../../Components/page-header/PageHeaderWithLink.vue';

  defineProps({
    character: { type: Object as PropType<CharacterEntityInterface>, required: true }
  })

  const campaignStore = useCampaignStore()
</script>

<template>

  <Head :title="character.name + ' Character'" />
  <CreatorDefaultContentLayout>
    <PageHeaderWithLink
      :href="route('creator.campaigns.characters.edit', { campaign: campaignStore.selectedCampaignId, character: character.id })">
      <template #title>{{ character.name }}</template><template #link><font-awesome-icon :icon="['fas', 'pencil']"
          fixed-width class="mr-2"></font-awesome-icon>Edit {{
            character.name ? character.name : 'Character' }}</template>
    </PageHeaderWithLink>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6">
      <ContentGroup><template #heading>Max hit points</template><template #content>{{
        character.max_hit_points
          }}</template></ContentGroup>
      <ContentGroup><template #heading>Armour class</template><template #content>{{
        character.armour_class
          }}</template></ContentGroup>
      <ContentGroup><template #heading>Dexterity modifier</template><template #content>{{
        character.dexterity_modifier }}</template></ContentGroup>
    </div>
    <ContentGroup><template #heading>Species</template><template #content>{{ character.species?.name ?? 'Not set'
        }}</template>
    </ContentGroup>
    <ContentGroup><template #heading>Appearance</template><template #content>{{ character.appearance }}</template>
    </ContentGroup>
    <ContentGroup><template #heading>Notes</template><template #content>{{ character.notes }}</template>
    </ContentGroup>
  </CreatorDefaultContentLayout>
</template>