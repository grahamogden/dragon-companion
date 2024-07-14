<script setup lang="ts">
  import { inject, ref } from 'vue'
  import { RouterLink, RouterView } from 'vue-router'
  import { getAuth } from 'firebase/auth'
  import { firebaseAppKey } from '../keys'
  import type { FirebaseApp } from 'firebase/app'
  import { useCampaignStore, useUserAuthStore } from '../stores'
  import CampaignPicker from '../components/campaign-picker/CampaignPicker.vue'
  import LoadingSpinner from '../components/loading-spinner/LoadingSpinner.vue'
  import NavLink from '../components/nav-link/NavLink.vue'
  import Breadcrumbs from '../components/breadcrumbs/Breadcrumbs.vue'

  const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
  const auth = getAuth(firebaseApp);
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
  <div class="max-w-page w-full m-0 lg:mx-auto lg:my-6 lg:px-6">
    <div class="flex flex-row rounded-3xl shadow-lg">
      <div class="fixed lg:relative bottom-24 lg:bottom-auto lg:flex flex-col w-full lg:max-w-64 z-10 bg-shark-950/75 backdrop-blur-lg mx-auto rounded-t-3xl lg:rounded-tr-none lg:rounded-l-3xl overflow-hidden text-center lg:text-left" :class="{ hidden: !isNavMenuOpen }">
        <CampaignPicker />

        <div class="flex flex-col w-full">
          <nav v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
            class="flex flex-col">
            <nav-link :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">Characters</nav-link>
            <nav-link :destination="{ name: 'combat-encounters', params: { externalCampaignId: campaignStore.campaignId } }">Combat Encounters</nav-link>
            <nav-link :destination="{ name: 'species.list', params: { externalCampaignId: campaignStore.campaignId } }">Species</nav-link>
            <nav-link :destination="{ name: 'tags', params: { externalCampaignId: campaignStore.campaignId } }">Tags</nav-link>
            <nav-link :destination="{ name: 'timelines.list', params: { externalCampaignId: campaignStore.campaignId } }">Timelines</nav-link>
          </nav>
          <div v-if="!(userAuthStore.isLoggedIn && campaignStore.isCampaignSelected)"
            class="w-full max-w-page text-timberwolf-100 py-3 px-4 mx-auto">Please select a campaign above to start
            crafting your world and story!</div>
        </div>
      </div>

      <main id="main-content w-full h-full"
        class="relative w-full">
        <div class="absolute top-0 left-0 w-full h-full bg-timberwolf-50/90 dark:bg-woodsmoke-950/90 backdrop-blur-xl lg:rounded-r-3xl duration-500"></div>
        <!-- <div class="absolute top-0 left-0 w-full h-full px-2 pt-4 pb-8 lg:p-4"> -->
        <div class="relative w-full h-full p-4 pb-8">
          <breadcrumbs></breadcrumbs>
          <Suspense>
            <RouterView />
            <template #fallback>
              <loading-spinner />
            </template>
          </Suspense>
        </div>
      </main>
    </div>
  </div>

  <nav
    class="fixed lg:hidden bottom-0 w-full toolbar grid grid-cols-5 bg-shark-950/85 backdrop-blur"
    v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected">
    <router-link class="text-white-lilac-50 py-3 text-center"
      :to="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }"><img
        src="@/assets/images/dice-icon.svg"
        class="w-12 h-12 block rounded inline-block" />Characters</router-link>
    <button type="button" class="text-white-lilac-50 py-3 underline text-center" @click="toggleNavMenu(); toggleAccountMenu(false)"><img
        src="@/assets/images/dice-icon.svg" class="w-12 h-12 block rounded inline-block" />More</button>
  </nav>
</template>