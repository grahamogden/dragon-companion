<script setup lang="ts">
  import { inject, onBeforeMount, ref, watch } from 'vue'
  import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router'
  import { getAuth, onAuthStateChanged, signOut } from 'firebase/auth'
  import { firebaseAppKey } from './keys'
  import type { FirebaseApp } from 'firebase/app'
  import { useCampaignStore, useUserAuthStore } from './stores'
  import CampaignPicker from './components/campaign-picker/CampaignPicker.vue'
  import { type DropDownItemButtonInterface, DropDownItemButton } from './components/interfaces/drop-down.item.interface'
  import DropDownMenu from './components/dropdowns/DropDownMenu.vue'

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

  // toggleDarkModeClass()

  // const darkModeToggleButtons: DropDownItemButtonInterface[] = [
  //   new DropDownItemButton(
  //     'Light',
  //     {
  //       func: toggleDarkModeSetLight,
  //       args: [],
  //     }
  //   ),
  //   new DropDownItemButton(
  //     'Dark',
  //     {
  //       func: toggleDarkModeSetDark,
  //       args: [],
  //     }
  //   ),
  //   new DropDownItemButton(
  //     'Auto',
  //     {
  //       func: toggleDarkModeSetAuto,
  //       args: [],
  //     }
  //   ),
  // ];

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
    class="absolute z-30 bg-leather-brown border-dashed border-parchment focus:border-2 focus:p-4 focus:underline max-h-0 focus:max-h-none overflow-hidden"
    ref="skipLink">Skip to main content</a>

  <header
    class="fixed lg:relative top-0 w-full bg-header-sky bg-bottom dark:bg-top bg-auto lg:bg-cover header-transition duration-500">
    <div class="max-w-page mx-auto flex flex-row items-center h-8 lg:h-20">
      <div class="hidden lg:block ml-20 text-3xl app-name text-spring-wood-50">
        Dragon Companion
      </div>
    </div>
  </header>

  <div class="fixed lg:sticky top-8 lg:top-0 flex flex-col w-full z-10">
    <div class="bg-gradient-to-r from-woodsmoke-700 to-woodsmoke-950">
      <div class="flex flex-row p-0 pl-20 pr-16 h-8 lg:h-12 justify-between items-center max-w-page mx-auto relative">
        <div class="fixed lg:absolute top-0 lg:top-auto lg:bottom-0 left-0 lg:h-96 z-10">
          <router-link to="/" class="top-2 left-2 w-16 h-16 p-1 lg:p-0 overflow-visible lg:sticky"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">
            <img class="logo w-full h-full inline-block" src="@/assets/images/dragon-companion-logo.svg"
              alt="Dragon Companion logo" />
          </router-link>
        </div>

        <div class="hidden lg:flex flex-row justify-between ">
          <router-link class="no-underline hover:underline py-2 text-biscay-200" :to="{ name: 'campaigns.list' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Your Campaigns</router-link>
          <img class="w-8 mx-6" src="@/assets/images/dice-icon.svg" />
          <CampaignPicker />
        </div>
        <nav
          class="absolute lg:relative right-0 lg:right-auto h-full flex flex-row gap-x-8 pl-2 pr-20 lg:pr-10 justify-between items-center bg-biscay-800">
          <div class="bg-biscay-800 skew-x-45 h-8 lg:h-12 w-8 lg:w-16 -left-4 lg:-left-10 absolute"></div>
          <!-- <div class="text-spring-wood-50">
            <DropDownMenu button-label="Theme" :links="darkModeToggleButtons" button-aria-context-name="Dark mode" />
          </div> -->
          <button
            class="relative h-8 w-[7rem] bg-theme-toggle bg-[length:auto_3.2rem] bg-no-repeat bg-clip-content rounded-full border border-spring-wood-50 p-2"
            :class="{ 'bg-[center_top_0.4rem]': themeSetting === 'light', 'bg-[center_top_-0.7rem]': themeSetting === 'dark', 'bg-[center_top_-1.8rem]': themeSetting === 'auto' }"
            @click="toggleDarkMode"></button>
          <router-link class="text-spring-wood-50 hidden lg:inline-block no-underline hover:underline"
            v-if="!userAuthStore.isLoggedIn" :to="{ name: 'user-register' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Register</router-link>
          <router-link class="text-spring-wood-50 hidden lg:inline-block no-underline hover:underline"
            v-if="!userAuthStore.isLoggedIn" :to="{ name: 'login' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Log In</router-link>
          <router-link class="text-spring-wood-50 hidden lg:inline-block no-underline hover:underline"
            v-if="userAuthStore.isLoggedIn" :to="{ name: 'user-account' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Account</router-link>
          <button class="text-spring-wood-50 hidden lg:inline-block no-underline hover:underline"
            v-if="userAuthStore.isLoggedIn" @click="toggleNavMenu(false); toggleAccountMenu(false); logOut();"
            type="button">Log Out</button>

          <button
            class="fixed lg:absolute top-2 lg:top-0 right-2 lg:-right-6 w-12 h-12 rounded-full overflow-hidden border-2 border-parchment bg-stone-800"
            @click="toggleNavMenu(false); toggleAccountMenu()" type="button" aria-label="Account menu toggle">
            <img class="logo w-full h-full" src="@/assets/logo.svg" alt="User account picture" />
          </button>
        </nav>
      </div>
    </div>

    <div class="hidden lg:block fixed lg:relative bottom-0">
      <div class="flex flex-row w-full bg-woodsmoke-950 border-b border-woodsmoke-900">
        <nav v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
          class="gap-x-4 flex flex-row text-center pl-20 w-full max-w-page mx-auto">
          <router-link class="no-underline hover:underline py-2 pr-4 text-biscay-200"
            :to="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Characters</router-link>
          <router-link class="no-underline hover:underline py-2 px-4 text-biscay-200"
            :to="{ name: 'combat-encounters', params: { externalCampaignId: campaignStore.campaignId } }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Combat Encounters</router-link>
          <router-link class="no-underline hover:underline py-2 px-4 text-biscay-200"
            :to="{ name: 'species.list', params: { externalCampaignId: campaignStore.campaignId } }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Species</router-link>
          <router-link class="no-underline hover:underline py-2 px-4 text-biscay-200"
            :to="{ name: 'timelines', params: { externalCampaignId: campaignStore.campaignId } }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Tags</router-link>
          <router-link class="no-underline hover:underline py-2 px-4 text-biscay-200"
            :to="{ name: 'timelines', params: { externalCampaignId: campaignStore.campaignId } }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Timelines</router-link>
        </nav>
        <div v-if="!(userAuthStore.isLoggedIn && campaignStore.isCampaignSelected)"
          class="w-full max-w-page text-timberwolf-100 pl-20 pr-4 py-2 mx-auto">Please select a campaign above to start
          crafting your world and story!</div>
      </div>
    </div>
  </div>

  <main id="main-content" class="px-4 pt-16 pb-24 lg:py-2 h-full w-full max-w-page mx-auto bg-timberwolf-200 dark:bg-woodsmoke-950 bg-repeat transition duration-500 grow">
    <Suspense>
      <RouterView />
      <template #fallback>
        <div class="rounded-full border-4 h-4 w-4 border-timberwolf-200"></div>
      </template>
    </Suspense>
  </main>

  <nav
    class="fixed lg:hidden bottom-0 w-full toolbar grid gap-x-4 grid-cols-5 bg-woodsmoke-950 border-t border-woodsmoke-900"
    v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected">
    <router-link class="text-biscay-200 p-2"
      :to="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }"><img
        src="@/assets/images/dice-icon.svg"
        class="w-12 h-12 block border border-timberwolf-100 rounded" />Characters</router-link>
    <button type="button" class="text-biscay-200 p-2 underline" @click="toggleNavMenu(); toggleAccountMenu(false)"><img
        src="@/assets/images/dice-icon.svg" class="w-12 h-12 block border border-timberwolf-100 rounded" />More</button>
  </nav>
</template>