<script setup lang="ts">
  import { inject, ref, watch, computed } from 'vue'
  import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router'
  import { getAuth, onAuthStateChanged, signOut } from 'firebase/auth'
  import { firebaseAppKey } from './keys'
  import type { FirebaseApp } from 'firebase/app'
  import { useCampaignStore, useUserAuthStore } from './stores'
  import LoadingSpinner from './components/loading-spinner/LoadingSpinner.vue'
  import SideNavigation from './components/navigation/SideNavigation.vue'
  import ToolbarNavigation from './components/navigation/ToolbarNavigation.vue'
  import Default from './layouts/Default.vue'
  import Dashboard from './layouts/Dashboard.vue'

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
  const route = useRoute()

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

  // Theme toggling

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

  // Layout

  const layout = computed(() => {
    switch (route?.meta?.layout) {
      case 'Dashboard':
        return Dashboard
      default:
        return Default
    }
  })

  // Tab indexing

  // Use a link with tabindex=-1 to reset the tabindex on page changes so that pressing tab once will go to the skipLink again
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
          <button
            class="relative h-8 w-[7rem] bg-theme-toggle bg-[length:auto_3.2rem] bg-no-repeat bg-clip-content rounded-full border border-timberwolf-50 p-2"
            :class="{ 'bg-[center_top_0.4rem]': themeSetting === 'light', 'bg-[center_top_-0.7rem]': themeSetting === 'dark', 'bg-[center_top_-1.8rem]': themeSetting === 'auto' }"
            @click="toggleDarkMode" aria-label="Toggle theme - light, dark and auto"></button>

          <router-link class="text-timberwolf-50 hidden md:inline-block hover:no-underline focus:no-underline"
            v-if="!userAuthStore.isLoggedIn" :to="{ name: 'user-register' }">Register</router-link>

          <router-link class="text-timberwolf-50 hidden md:inline-block hover:no-underline focus:no-underline"
            v-if="!userAuthStore.isLoggedIn" :to="{ name: 'login' }">Log In</router-link>

          <router-link class="text-timberwolf-50 hidden md:inline-block hover:no-underline focus:no-underline"
            v-if="userAuthStore.isLoggedIn" :to="{ name: 'campaigns.list' }">Campaigns</router-link>

          <router-link class="text-timberwolf-50 hidden md:inline-block hover:no-underline focus:no-underline"
            v-if="userAuthStore.isLoggedIn" :to="{ name: 'user-account' }">Account</router-link>

          <button class="text-timberwolf-50 hidden md:inline-block hover:no-underline focus:no-underline border-0"
            v-if="userAuthStore.isLoggedIn" @click="logOut();" type="button">Log Out</button>

          <button class="w-12 h-12 rounded-full overflow-hidden border-2 border-timberwolf-50 bg-stone-800 p-0"
            type="button" aria-label="Account menu toggle">
            <img class="logo w-full h-full" src="@/assets/logo.svg" alt="User account picture" />
          </button>
        </nav>
      </div>
    </div>
  </header>

  <component :is="layout">
    <Suspense>
      <RouterView />
      <template #fallback>
        <loading-spinner />
      </template>
    </Suspense>
  </component>

  <ToolbarNavigation></ToolbarNavigation>
</template>