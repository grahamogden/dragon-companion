<script setup lang="ts">
  import { inject, ref, watch } from 'vue'
  import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router'
  import { getAuth, onAuthStateChanged, signOut } from 'firebase/auth'
  import { firebaseAppKey } from './keys'
  import type { FirebaseApp } from 'firebase/app'
  import { useCampaignStore, useUserAuthStore } from './stores'
  import LoadingSpinner from './components/loading-spinner/LoadingSpinner.vue'
  import Breadcrumbs from './components/breadcrumbs/Breadcrumbs.vue'
  import BannerContainer from './components/alert-banner/BannerContainer.vue'
  import Navigation from './components/navigation/Navigation.vue'

  const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
  const auth = getAuth(firebaseApp);
  const campaignStore = useCampaignStore()
  const userAuthStore = useUserAuthStore()

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
    campaignStore.reset()

    signOut(auth).then(() => {
      console.debug(('Logged out'));

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

  const themeSetting = ref('auto')

  function toggleDarkModeClass(themeSetting: string): void {
    // if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    if (themeSetting === 'dark'
      || (themeSetting === 'auto'
        && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }
  }

  function toggleDarkModeSetLight() {
    themeSetting.value = 'light'
    localStorage.setItem('theme', 'light')
    toggleDarkModeClass('light')
  }

  function toggleDarkModeSetDark() {
    themeSetting.value = 'dark'
    localStorage.setItem('theme', 'dark')
    toggleDarkModeClass('dark')
  }

  function toggleDarkModeSetAuto() {
    themeSetting.value = 'auto'
    localStorage.removeItem('theme')
    toggleDarkModeClass('auto')
  }

  function toggleDarkMode() {
    if (themeSetting.value === 'dark') {
      toggleDarkModeSetLight()
    } else if (themeSetting.value === 'light') {
      toggleDarkModeSetDark()
    } else {
      toggleDarkModeSetAuto()
    }
  }

  function getLocalStorageThemeSetting() {
    if (localStorage.getItem('theme') === 'light') {
      return 'light'
    } else if (localStorage.getItem('theme') === 'dark') {
      return 'dark'
    } else {
      return 'auto'
    }
  }

  function synchroniseThemeWithLocalStorage() {
    if (getLocalStorageThemeSetting() === 'light') {
      toggleDarkModeSetLight()
    } else if (getLocalStorageThemeSetting() === 'dark') {
      toggleDarkModeSetDark()
    } else {
      toggleDarkModeSetAuto()
    }
  }

  synchroniseThemeWithLocalStorage()

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
  <a tabindex="-1" ref="skipLinkReset" class="absolute"></a>
  <a href="#main-content"
    class="absolute z-30 focus:p-4 focus:underline max-h-0 focus:max-h-none bg-white-lilac-50 dark:bg-shark-950 overflow-hidden"
    ref="skipLink">Skip to main content</a>

  <header class="w-full bg-shark-950/70 backdrop-blur-lg shadow-lg">
    <div class="flex flex-row justify-between items-center max-w-page mx-auto py-2 md:py-4 px-4 md:px-6 relative">
      <div class="flex flex-row items-center">
        <div class="z-10">
          <router-link to="/" class="top-2 left-2 w-12 h-12 p-1 md:p-0 overflow-visible"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">
            <img class="logo w-full h-full inline-block" src="@/assets/images/logo-8.svg" alt="Dragon Companion logo" />
          </router-link>
        </div>
        <div class="hidden md:block ml-2 text-3xl app-name text-timberwolf-50 tracking-wide">
          Dragon Companion <span class="text-xs">(Beta)</span>
        </div>
      </div>

      <div class="flex flex-row">
        <nav class="h-full flex flex-row gap-x-8 justify-between items-center">
          <!-- <div class="bg-biscay-800 skew-x-45 h-8 md:h-12 w-8 md:w-16 -left-4 md:-left-10 absolute"></div> -->
          <!-- <div class="text-timberwolf-50">
            <DropDownMenu button-label="Theme" :links="darkModeToggleButtons" button-aria-context-name="Dark mode" />
          </div> -->
          <button
            class="relative h-8 w-[7rem] bg-theme-toggle bg-[length:auto_3.2rem] bg-no-repeat bg-clip-content rounded-full border border-timberwolf-50 p-2"
            :class="{ 'bg-[center_top_0.4rem]': themeSetting === 'light', 'bg-[center_top_-0.7rem]': themeSetting === 'dark', 'bg-[center_top_-1.8rem]': themeSetting === 'auto' }"
            @click="toggleDarkMode" aria-label="Toggle theme - light, dark and auto"></button>
          <router-link class="text-timberwolf-50 hidden md:inline-block no-underline hover:underline"
            v-if="!userAuthStore.isLoggedIn" :to="{ name: 'user-register' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Register</router-link>
          <router-link class="text-timberwolf-50 hidden md:inline-block no-underline hover:underline"
            v-if="!userAuthStore.isLoggedIn" :to="{ name: 'login' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Log In</router-link>
          <router-link class="text-timberwolf-50 hidden md:inline-block no-underline hover:underline"
            v-if="userAuthStore.isLoggedIn" :to="{ name: 'user-account' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Account</router-link>
          <button class="text-timberwolf-50 hidden md:inline-block no-underline hover:underline border-0"
            v-if="userAuthStore.isLoggedIn" @click="toggleNavMenu(false); toggleAccountMenu(false); logOut();"
            type="button">Log Out</button>

          <button class="w-12 h-12 rounded-full overflow-hidden border-2 border-timberwolf-50 bg-stone-800 p-0"
            @click="toggleNavMenu(false); toggleAccountMenu()" type="button" aria-label="Account menu toggle">
            <img class="logo w-full h-full" src="@/assets/logo.svg" alt="User account picture" />
          </button>
        </nav>
      </div>
    </div>
  </header>

  <div class="max-w-page w-full m-0 mb-24 md:mx-auto md:my-6 md:px-6">
    <div class="flex flex-row rounded-3xl shadow-lg">
      <div
        class="relative hidden md:flex flex-col w-full md:max-w-64 bg-shark-950/70 backdrop-blur-lg mx-auto rounded-tr-none rounded-l-3xl overflow-hidden text-left">
        <navigation></navigation>
      </div>

      <main id="main-content"
        class="relative w-full h-full before:content-[''] before:absolute before:top-0 before:left-0 before:w-full before:h-full before:bg-timberwolf-50/80 before:dark:bg-woodsmoke-950/80 before:backdrop-blur-xl before:md:rounded-r-3xl before:duration-theme-change">
        <!-- <div class="absolute top-0 left-0 w-full h-full bg-timberwolf-50/80 dark:bg-woodsmoke-950/80 backdrop-blur-xl md:rounded-r-3xl duration-theme-change"></div> -->
        <!-- <div class="absolute top-0 left-0 w-full h-full px-2 pt-4 pb-8 md:p-4"> -->
        <div v-if="campaignStore.isCampaignSelected" class="relative md:hidden p-2 border-b border-timberwolf-50/25">
          Selected campaign: {{
              campaignStore.campaignName }}</div>
        <div class="relative w-full h-full p-2 md:p-4 pb-8">
          <banner-container />
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

  <Transition name="scale">
    <div v-show="isNavMenuOpen"
      class="fixed bottom-24 md:hidden flex-col w-full z-10 bg-shark-950/70 backdrop-blur-lg mx-auto rounded-t-3xl overflow-hidden text-center">
      <navigation></navigation>
    </div>
  </Transition>
  <nav class="fixed md:hidden bottom-0 w-full toolbar grid grid-cols-4 gap-4 bg-shark-950/85 backdrop-blur z-10"
    v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected">
    <router-link class="text-white-lilac-50 py-3 text-center"
      :to="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }"><img
        src="@/assets/images/dice-icon.svg" class="w-12 h-12 block rounded inline-block" /><span
        class="inline-block w-full truncate text-ellipsis overflow-hidden">Characters</span></router-link>
    <button type="button" class="text-white-lilac-50 py-3 underline text-center"
      @click="toggleNavMenu(); toggleAccountMenu(false)"><img src="@/assets/images/dice-icon.svg"
        class="w-12 h-12 block rounded inline-block" /><span
        class="inline-block w-full truncate text-ellipsis overflow-hidden">More</span></button>
  </nav>
  <div v-if="isNavMenuOpen" @click="toggleNavMenu(false)"
    class="fixed top-0 left-0 w-full h-full bg-stone-950 opacity-50 md:hidden"></div>
</template>

<style>

  /* .v-enter-from,
  .v-leave-to,
  .v-enter-from div,
  .v-leave-to div {
    line-height: 0;
    font-size: 0;
  }

  .v-enter-from a,
  .v-leave-to a,
  .v-enter-from div,
  .v-leave-to div {
    padding: 0;
  }

  .v-enter-from .campaign-picker,
  .v-leave-to .campaign-picker {
    height: 0;
  }

  .v-enter-active,
  .v-leave-active,
  .v-enter-active a,
  .v-leave-active a,
  .v-enter-active div,
  .v-leave-active div,
  .v-enter-active .campaign-picker,
  .v-leave-active .campaign-picker {
    transition-property: padding, line-height, font-size, height;
    transition-duration: 0.3s;
    transition-timing-function: ease;
    transition-delay: 0ms;
  }

  .v-enter-to,
  .v-leave-from,
  .v-enter-to div,
  .v-leave-from div {
    line-height: normal;
    font-size: normal;
  } */

  .scale-enter-from,
  .scale-leave-to {
    bottom: 0rem;
    transform: scale(1, 0);
  }

  .scale-enter-active,
  .scale-leave-active {
    transition-property: transform, bottom;
    transition-duration: 0.3s;
    transition-timing-function: ease;
    transition-delay: 0ms;
    transform-origin: center bottom;
  }

  .scale-enter-to,
  .scale-leave-from {
    transform: scale(1, 1);
  }
</style>