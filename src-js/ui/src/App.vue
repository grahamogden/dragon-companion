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
  import LoadingSpinner from './components/loading-spinner/LoadingSpinner.vue'
  import NavLink from './components/nav-link/NavLink.vue'
  import Breadcrumbs from './components/breadcrumbs/Breadcrumbs.vue'

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
    class="absolute z-30 focus:p-4 focus:underline max-h-0 focus:max-h-none bg-white-lilac-50 overflow-hidden"
    ref="skipLink">Skip to main content</a>

  <header class="w-full bg-shark-950/85 backdrop-blur shadow-lg">
    <div class="flex flex-row justify-between items-center max-w-page mx-auto py-2 lg:py-4 px-4 lg:px-6 relative">
      <div class="flex flex-row items-center">
        <div class="z-10">
          <router-link to="/" class="top-2 left-2 w-12 h-12 p-1 lg:p-0 overflow-visible"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">
            <img class="logo w-full h-full inline-block" src="@/assets/images/logo-8.svg" alt="Dragon Companion logo" />
          </router-link>
        </div>
        <div class="hidden lg:block ml-2 text-3xl app-name text-timberwolf-50">
          Dragon Companion
        </div>
      </div>

      <div class="flex flex-row">
        <nav
          class="h-full flex flex-row gap-x-8 justify-between items-center">
          <!-- <div class="bg-biscay-800 skew-x-45 h-8 lg:h-12 w-8 lg:w-16 -left-4 lg:-left-10 absolute"></div> -->
          <!-- <div class="text-timberwolf-50">
            <DropDownMenu button-label="Theme" :links="darkModeToggleButtons" button-aria-context-name="Dark mode" />
          </div> -->
          <button
            class="relative h-8 w-[7rem] bg-theme-toggle bg-[length:auto_3.2rem] bg-no-repeat bg-clip-content rounded-full border border-timberwolf-50 p-2"
            :class="{ 'bg-[center_top_0.4rem]': themeSetting === 'light', 'bg-[center_top_-0.7rem]': themeSetting === 'dark', 'bg-[center_top_-1.8rem]': themeSetting === 'auto' }"
            @click="toggleDarkMode" aria-label="Toggle theme - light, dark and auto"></button>
          <router-link class="text-timberwolf-50 hidden lg:inline-block no-underline hover:underline"
            v-if="!userAuthStore.isLoggedIn" :to="{ name: 'user-register' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Register</router-link>
          <router-link class="text-timberwolf-50 hidden lg:inline-block no-underline hover:underline"
            v-if="!userAuthStore.isLoggedIn" :to="{ name: 'login' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Log In</router-link>
          <router-link class="text-timberwolf-50 hidden lg:inline-block no-underline hover:underline"
            v-if="userAuthStore.isLoggedIn" :to="{ name: 'user-account' }"
            @click="toggleNavMenu(false); toggleAccountMenu(false)">Account</router-link>
          <button class="text-timberwolf-50 hidden lg:inline-block no-underline hover:underline border-0"
            v-if="userAuthStore.isLoggedIn" @click="toggleNavMenu(false); toggleAccountMenu(false); logOut();"
            type="button">Log Out</button>

          <button
            class="w-12 h-12 rounded-full overflow-hidden border-2 border-timberwolf-50 bg-stone-800 p-0"
            @click="toggleNavMenu(false); toggleAccountMenu()" type="button" aria-label="Account menu toggle">
            <img class="logo w-full h-full" src="@/assets/logo.svg" alt="User account picture" />
          </button>
        </nav>
      </div>
    </div>
  </header>

  <div class="max-w-page w-full m-0 lg:mx-auto lg:my-6 lg:px-6">
    <div class="flex flex-row rounded-3xl shadow-lg">
      <div class="fixed lg:relative bottom-24 lg:bottom-auto lg:flex flex-col w-full lg:max-w-64 z-10 bg-shark-950/85 backdrop-blur mx-auto rounded-t-3xl lg:rounded-tr-none lg:rounded-l-3xl overflow-hidden text-center lg:text-left" :class="{ hidden: !isNavMenuOpen }">
        <CampaignPicker />

        <div class="flex flex-col w-full">
          <nav v-if="userAuthStore.isLoggedIn && campaignStore.isCampaignSelected"
            class="flex flex-col">
            <nav-link :destination="{ name: 'characters', params: { externalCampaignId: campaignStore.campaignId } }">Characters</nav-link>
            <nav-link :destination="{ name: 'combat-encounters', params: { externalCampaignId: campaignStore.campaignId } }">Combat Encounters</nav-link>
            <nav-link :destination="{ name: 'species.list', params: { externalCampaignId: campaignStore.campaignId } }">Species</nav-link>
            <nav-link :destination="{ name: 'timelines', params: { externalCampaignId: campaignStore.campaignId } }">Tags</nav-link>
            <nav-link :destination="{ name: 'timelines', params: { externalCampaignId: campaignStore.campaignId } }">Timelines</nav-link>
          </nav>
          <div v-if="!(userAuthStore.isLoggedIn && campaignStore.isCampaignSelected)"
            class="w-full max-w-page text-timberwolf-100 py-3 px-4 mx-auto">Please select a campaign above to start
            crafting your world and story!</div>
        </div>
      </div>

      <main id="main-content w-full h-full"
        class="relative w-full">
        <div class="absolute top-0 left-0 w-full h-full bg-timberwolf-50/90 dark:bg-woodsmoke-950/90 backdrop-blur-sm lg:rounded-r-3xl duration-500"></div>
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