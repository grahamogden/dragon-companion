<script setup lang="ts">
  import { inject, ref, watch } from 'vue'
  import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router'
  import { getAuth, onAuthStateChanged, signOut } from 'firebase/auth'
  import { firebaseAppKey } from './keys'
  import type { FirebaseApp } from 'firebase/app'
  import { useCampaignStore, useUserAuthStore } from './stores'
  import CampaignPicker from './components/campaign-picker/CampaignPicker.vue'

  const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
  const auth = getAuth(firebaseApp);
  const campaignStore = useCampaignStore()
  const userAuthStore = useUserAuthStore()
  // const isLoggedIn = ref(userStore.isLoggedIn)

  onAuthStateChanged(
    auth,
    (user) => {
      userAuthStore.setUser(user)
      if (user === null) {
        campaignStore.reset()
        console.debug('Reset campaign storage')
      }
    }
  )

  const router = useRouter()

  const logOut = () => {
    const auth = getAuth(inject(firebaseAppKey));

    signOut(auth).then(() => {
      console.debug(('Logged out'));
      campaignStore.reset()

      router.push('/login')
    }).catch((error) => {
      console.error(error)
    });
  }

  function toggleNavMenu(open: boolean | undefined = undefined) {
    if (open === undefined) {
      isNavMenuOpen.value = !isNavMenuOpen.value
    } else {
      isNavMenuOpen.value = open
    }
    // const menu = document.getElementById('nav-menu')!
    // toggleMenu(menu, open)
  }

  function toggleAccountMenu(open: boolean | undefined = undefined) {
    if (open === undefined) {
      isAccountMenuOpen.value = !isAccountMenuOpen.value
    } else {
      isAccountMenuOpen.value = open
    }
    // const menu = document.getElementById('account-menu')!
    // toggleMenu(menu, open)
  }

  function toggleMenu(menu: HTMLElement, open: boolean | undefined = undefined) {
    // if (open === undefined) {
    //   menu.classList.toggle('open')
    // } else if (open) {
    //   menu.classList.add('open')
    // } else {
    //   menu.classList.remove('open')
    // }
  }

  const isNavMenuOpen = ref(false)
  const isAccountMenuOpen = ref(false)

  // Use a link with tabindex=-1 to reset the tabindex on page changes so that pressing tab once will go to the skipLink again
  const route = useRoute()
  const skipLinkReset = ref()

  watch(
    () => route.path,
    () => {
      skipLinkReset.value.focus()
    }
  )
</script>
<template>
  <a tabindex="-1" ref="skipLinkReset"></a>
  <a href="#main-content"
    class="absolute z-30 bg-leather-brown border-dashed border-parchment-pale focus:border-2 focus:p-4 text-parchment-pale focus:underline max-h-0 focus:max-h-none overflow-hidden"
    ref="skipLink">Skip to main content</a>
  <header class="fixed lg:absolute top-0 z-20 w-full lg:fixed-center max-w-page lg:px-14 content-box">
    <router-link to="/"
      class="absolute top-2 left-2 w-20 h-20 rounded-full overflow-hidden border-2 border-white bg-stone-800 z-10 lg:top-0 lg:left-4"
      @click="toggleNavMenu(false); toggleAccountMenu(false)">
      <img class="logo" src="@/assets/logo.svg" width="125" height="125" alt="Dragon Companion logo" />
    </router-link>

    <button
      class="nav stitching-bottom bg-leather-brown bg-leather-texture bg-repeat bg-left-top flex-col shadow-md shadow-neutral-950 py-4 min-h-12 rounded-none w-full block"
      @click="toggleNavMenu(); toggleAccountMenu(false)" type="button" aria-label="Navigation menu toggle"></button>

    <nav v-if="isNavMenuOpen" id="nav-menu" class="nav stitching-bottom bg-leather-brown bg-leather-texture bg-repeat bg-left-top flex flex-col lg:hidden">
      <CampaignPicker />
      <router-link class="nav-link" :to="{ name: 'campaigns.list' }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Campaigns</router-link>
      <router-link class="nav-link" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Characters</router-link>
      <router-link class="nav-link" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'classes', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Classes</router-link>
      <router-link class="nav-link" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'combat-encounters', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Combat Encounters</router-link>
      <router-link class="nav-link" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'species', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Species</router-link>
      <router-link class="nav-link" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'timelines', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Timelines</router-link>
    </nav>

    <nav class="flex flex-row gap-x-4 hidden lg:block">
      <router-link class="nav-link bg-navigation-leather-tab bg-bottom px-4 py-6 bg-no-repeat bg-cover w-44 table-cell align-bottom" :to="{ name: 'campaigns.list' }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Campaigns</router-link>
      <router-link class="nav-link bg-navigation-leather-tab bg-bottom px-4 py-6 bg-no-repeat bg-cover w-44 table-cell align-bottom" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Characters</router-link>
      <router-link class="nav-link bg-navigation-leather-tab bg-bottom px-4 py-6 bg-no-repeat bg-cover w-44 table-cell align-bottom" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'classes', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Classes</router-link>
      <router-link class="nav-link bg-navigation-leather-tab bg-bottom px-4 py-6 bg-no-repeat bg-cover w-44 table-cell align-bottom" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'combat-encounters', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Combat Encounters</router-link>
      <router-link class="nav-link bg-navigation-leather-tab bg-bottom px-4 py-6 bg-no-repeat bg-cover w-44 table-cell align-bottom" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'species', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Species</router-link>
      <router-link class="nav-link bg-navigation-leather-tab bg-bottom px-4 py-6 bg-no-repeat bg-cover w-44 table-cell align-bottom" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
        :to="{ name: 'timelines', params: { externalCampaignId: campaignStore.campaignId } }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Timelines</router-link>
    </nav>

    <div v-if="isAccountMenuOpen" id="account-menu" class="nav stitching-bottom bg-leather-brown bg-leather-texture bg-repeat bg-left-top flex flex-col lg:hidden">
      <router-link class="nav-link" to="/" @click="toggleNavMenu(false); toggleAccountMenu(false)">Home!</router-link>
      <router-link class="nav-link" v-if="!userAuthStore.isLoggedIn" :to="{ name: 'user-register' }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Register</router-link>
      <router-link class="nav-link" v-if="!userAuthStore.isLoggedIn" :to="{ name: 'login' }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Log In</router-link>
      <router-link class="nav-link" v-if="userAuthStore.isLoggedIn" :to="{ name: 'user-account' }"
        @click="toggleNavMenu(false); toggleAccountMenu(false)">Account</router-link>
      <a class="nav-link" v-if="userAuthStore.isLoggedIn"
        @click="toggleNavMenu(false); toggleAccountMenu(false); logOut();">Log Out</a>
    </div>

    <button class="absolute top-2 right-2 w-20 h-20 rounded-full overflow-hidden border-2 border-white bg-stone-800 lg:top-0 lg:right-4"
      @click="toggleNavMenu(false); toggleAccountMenu()" type="button" aria-label="Account menu toggle">
      <img class="logo" src="@/assets/logo.svg" width="125" height="125" alt="User account picture" />
    </button>

  </header>

  <main id="main-content"
    class="z-10 pt-24 p-2 bg-parchment-pale dark:bg-parchment-dark bg-content-texture bg-repeat bg-left-top dark:bg-none h-full">
    <RouterView />
  </main>

  <nav class="toolbar fixed w-full bottom-0 bg-leather-brown bg-leather-texture stitching-top lg:hidden">
    <router-link class="nav-link" v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
      :to="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">Characters</router-link>
    <button type="button" class="nav-link underline" @click="toggleNavMenu(); toggleAccountMenu(false)">More</button>
  </nav>
</template>