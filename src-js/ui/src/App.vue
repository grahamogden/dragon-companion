<script setup lang="ts">
  import { inject, ref, watch, computed } from 'vue'
  import { RouterLink, RouterView, useRoute } from 'vue-router'
  import { getAuth, onAuthStateChanged } from 'firebase/auth'
  import { firebaseAppKey } from './keys'
  import type { FirebaseApp } from 'firebase/app'
  import { useCampaignStore, useUserAuthStore, useConfigurationStore, ThemeEnum } from './stores'
  import LoadingSpinner from './components/loading-spinner/LoadingSpinner.vue'
  import ToolbarNavigation from './components/navigation/ToolbarNavigation.vue'
  import Default from './layouts/Default.vue'
  import Dashboard from './layouts/Dashboard.vue'
  import HeaderAccountMenu from './components/header/account/HeaderAccountMenu.vue'
  import SlimDefault from './layouts/SlimDefault.vue'
  import Home from './layouts/Home.vue'

  const firebaseApp: FirebaseApp = inject(firebaseAppKey)!
  const auth = getAuth(firebaseApp);
  const campaignStore = useCampaignStore()
  const userAuthStore = useUserAuthStore()
  const configStore = useConfigurationStore()
  const route = useRoute()

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

  // Theme toggling

  function toggleDarkModeClass(themeSetting: string): void {
    if (themeSetting === ThemeEnum.DARK
      || (themeSetting === ThemeEnum.AUTO
        && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
      document.documentElement.classList.add(ThemeEnum.DARK)
    } else {
      document.documentElement.classList.remove(ThemeEnum.DARK)
    }
  }

  window.matchMedia("(prefers-color-scheme: dark)").addEventListener('change', e => {
    if (configStore.theme !== ThemeEnum.AUTO) {
      return
    }

    if (e.matches) {
      toggleDarkModeClass(ThemeEnum.DARK)
    } else {
      toggleDarkModeClass(ThemeEnum.LIGHT)
    }
  });

  function toggleDarkModeSetLight() {
    configStore.setTheme(ThemeEnum.LIGHT)
    toggleDarkModeClass(ThemeEnum.LIGHT)
  }

  function toggleDarkModeSetDark() {
    configStore.setTheme(ThemeEnum.DARK)
    toggleDarkModeClass(ThemeEnum.DARK)
  }

  function toggleDarkModeSetAuto() {
    configStore.setTheme(ThemeEnum.AUTO)
    toggleDarkModeClass(ThemeEnum.AUTO)
  }

  /**
   * Switches the theme to the next setting:
   * Light -> dark -> auto
   */
  function toggleDarkMode() {
    switch (configStore.theme) {
      case (ThemeEnum.LIGHT):
        toggleDarkModeSetDark()
        break;
      case (ThemeEnum.DARK):
        // Auto needs uncommenting when we want auto back here
        // toggleDarkModeSetAuto()
        toggleDarkModeSetLight()
        break;
      default:
        toggleDarkModeSetLight()
        break;
    }
  }

  function synchroniseThemeWithLocalStorage() {
    switch (configStore.theme) {
      case (ThemeEnum.LIGHT):
        toggleDarkModeSetLight()
        break;
      case (ThemeEnum.DARK):
        toggleDarkModeSetDark()
        break;
      default:
        toggleDarkModeSetAuto()
        break;
    }
  }

  synchroniseThemeWithLocalStorage()

  // Layout

  const layout = computed(() => {
    switch (route?.meta?.layout) {
      case 'Dashboard':
        return Dashboard
      case 'Home':
        return Home
      case 'SlimDefault':
        return SlimDefault
      default:
        return Default
    }
  })

  // Prevent scrolling

  watch(() => configStore.isBodyFixed, (isBodyFixed) => {
    if (isBodyFixed) {
      document.body.classList.add('overflow-hidden')
    } else {
      document.body.classList.remove('overflow-hidden')
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

  <header class="relative w-full">
    <div class="absolute w-full h-full top-0 bg-shark-950/70 backdrop-blur-lg shadow-lg"></div>
    <div class="flex flex-row justify-between items-center max-w-page mx-auto py-2 md:py-4 px-4 md:px-6 relative">
      <div class="flex flex-row items-center">
        <div class="z-10">
          <router-link to="/" class="top-2 left-2 w-12 h-12 p-1 md:p-0 overflow-visible">
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
            class="relative grid grid-cols-3 gap-1 text-woodsmoke-300 rounded-full border border-timberwolf-50 p-1 text-xl"
            @click="toggleDarkMode" aria-label="Toggle theme - auto, light and dark"><font-awesome-icon
              :icon="['fas', 'circle-half-stroke']" fixed-width
              :class="{ 'text-timberwolf-50': configStore.theme === ThemeEnum.AUTO }"></font-awesome-icon><font-awesome-icon
              :icon="[configStore.theme === ThemeEnum.LIGHT ? 'fas' : 'far', 'sun']" fixed-width
              :class="{ 'text-timberwolf-50': configStore.theme === ThemeEnum.LIGHT }"></font-awesome-icon><font-awesome-icon
              :icon="[configStore.theme === ThemeEnum.DARK ? 'fas' : 'far', 'moon']" fixed-width
              :class="{ 'text-timberwolf-50': configStore.theme === ThemeEnum.DARK }"></font-awesome-icon></button>

          <router-link class="text-timberwolf-50 hidden md:inline-block hover:no-underline focus:no-underline"
            v-if="!userAuthStore.isLoggedIn" :to="{ name: 'user-register' }"><font-awesome-icon :icon="['fas', 'star']"
              fixed-width class="mr-2"></font-awesome-icon>Register</router-link>

          <router-link class="text-timberwolf-50 hover:no-underline focus:no-underline" v-if="!userAuthStore.isLoggedIn"
            :to="{ name: 'login' }"><font-awesome-icon :icon="['fas', 'right-to-bracket']" fixed-width
              class="mr-2" />Log In</router-link>

          <router-link class="text-timberwolf-50 hidden md:inline-block hover:no-underline focus:no-underline"
            v-if="userAuthStore.isLoggedIn" :to="{ name: 'campaigns.list' }"><font-awesome-icon :icon="['fas', 'book']"
              fixed-width class="mr-2" />Campaigns</router-link>

          <HeaderAccountMenu v-if="userAuthStore.isLoggedIn"></HeaderAccountMenu>
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

  <div v-if="configStore.isOverlayActive" @click="configStore.setOverlayActive(false)"
    class="fixed top-0 left-0 w-full h-full bg-stone-950 opacity-50 md:hidden"></div>
</template>