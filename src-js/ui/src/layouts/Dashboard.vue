<script setup lang="ts">
  import { ref } from 'vue'
  import { useCampaignStore, useUserAuthStore } from '../stores'
  import SideNavigation from '../components/navigation/SideNavigation.vue'
  import Breadcrumbs from '../components/breadcrumbs/Breadcrumbs.vue'
  import BannerContainer from '../components/alert-banner/BannerContainer.vue'

  const campaignStore = useCampaignStore()
  const userAuthStore = useUserAuthStore()

  function toggleNavMenu(open: boolean | undefined = undefined) {
    if (open === undefined) {
      isNavMenuOpen.value = !isNavMenuOpen.value
    } else {
      isNavMenuOpen.value = open
    }
  }

  function toggleAccountMenu(open: boolean | undefined = undefined) {
    if (open === undefined) {
      isAccountMenuOpen.value = !isAccountMenuOpen.value
    } else {
      isAccountMenuOpen.value = open
    }
  }

  const isNavMenuOpen = ref(false)
  const isAccountMenuOpen = ref(false)

</script>
<template>
  <div class="max-w-page w-full m-0 mb-24 md:mx-auto md:my-6 md:px-6">
    <div class="flex flex-row content-stretch rounded-3xl shadow-lg">
      <SideNavigation></SideNavigation>

      <main id="main-content"
        class="relative w-full h-auto before:content-[''] before:absolute before:top-0 before:left-0 before:w-full before:h-full before:bg-timberwolf-50/80 before:dark:bg-woodsmoke-950/80 before:backdrop-blur-xl before:md:rounded-r-3xl before:duration-theme-change">
        <!-- <div v-if="campaignStore.isCampaignSelected" class="relative md:hidden p-2 border-b border-timberwolf-50/25">
          Selected campaign: {{ campaignStore.campaignName }}</div> -->
        <div class="relative w-full h-full p-2 md:p-6">
          <BannerContainer></BannerContainer>
          <Breadcrumbs></Breadcrumbs>
          <slot></slot>
        </div>
      </main>
    </div>
  </div>
</template>