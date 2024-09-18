<script setup lang="ts">
  import { ref } from 'vue';
  import { useCampaignStore, useCharacterStore } from '../../stores';
  import { CharacterEntity, type CharacterEntityInterface } from '../../services/character';
  import PageHeader from '../../Components/page-header/PageHeader.vue';
  import LoadingPage from '../../Components/loading-page/LoadingPage.vue'
  import { useRoute } from 'vue-router';
  import ContentGroup from '../../Components/elements/ContentGroup.vue'
  import { PageHeaderLink, PageHeaderLinkActionEnum } from '../../Components/page-header/interface';

  const characterStore = useCharacterStore()
  const route = useRoute()
  const campaign = useCampaignStore()
  const campaignId = campaign.selectedCampaignId!
  const characterId = parseInt(route.params.characterId as string)
  let isLoading = ref(true)
  let character = ref<CharacterEntityInterface>(new CharacterEntity())

  characterStore.getOneCharacter(campaignId, characterId).then((characterRes) => {
    if (characterRes !== null) {
      character.value = characterRes
    }
    isLoading.value = false
  })
</script>

<template>
  <div class="character-view">
    <page-header
      :link="new PageHeaderLink('Edit', { name: 'characters.edit', params: { externalCampaignId: campaignId, characterId: characterId } }, PageHeaderLinkActionEnum.EDIT)">{{
        character.name ? character.name : 'Character' }} ({{ character.age
      }})</page-header>
    <loading-page :is-loading="isLoading">
      <template #content>
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
        <ContentGroup><template #heading>Species</template><template #content>{{ character.species?.name }}</template>
        </ContentGroup>
        <ContentGroup><template #heading>Appearance</template><template #content>{{ character.appearance }}</template>
        </ContentGroup>
        <ContentGroup><template #heading>Notes</template><template #content>{{ character.notes }}</template>
        </ContentGroup>
      </template>
      <template #loading-text>character</template>
    </loading-page>
  </div>
</template>