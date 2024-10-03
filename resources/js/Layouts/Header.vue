<script setup lang="ts">
    import { useConfigurationStore, ThemeEnum } from '../stores/index'
    import HeaderAccountMenu from '../Components/header/account/HeaderAccountMenu.vue'
    import { Link } from '@inertiajs/vue3';

    const configStore = useConfigurationStore()

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
                toggleDarkModeSetAuto()
                // toggleDarkModeSetLight()
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
</script>
<template>
    <a tabindex="-1" ref="skipLinkReset" class="absolute"></a>
    <a href="#main-content"
        class="absolute z-30 focus:p-4 focus:underline max-h-0 focus:max-h-none bg-white-lilac-50 dark:bg-shark-950 overflow-hidden"
        ref="skipLink">Skip to main content</a>

    <header class="relative w-full">
        <div class="absolute w-full h-full top-0 bg-shark-950/70 backdrop-blur-sm shadow-lg"></div>
        <div class="flex flex-row justify-between items-center max-w-page mx-auto py-2 md:py-4 px-4 md:px-6 relative">
            <div class="flex flex-row items-center">
                <div>
                    <Link href="/" class="top-2 left-2 w-12 h-12 p-1 md:p-0 overflow-visible">
                    <img class="logo w-full h-full inline-block" src="@/assets/images/logo-8.svg"
                        alt="Dragon Companion logo" />
                    </Link>
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

                    <Link class="text-timberwolf-50 hidden md:inline-block hover:no-underline focus:no-underline"
                        v-if="!$page.props.auth.user" :href="route('register')"><font-awesome-icon
                        :icon="['fas', 'star']" fixed-width class="mr-2"></font-awesome-icon>Register</Link>

                    <Link class="text-timberwolf-50 hover:no-underline focus:no-underline" v-if="!$page.props.auth.user"
                        :href="route('login')"><font-awesome-icon :icon="['fas', 'right-to-bracket']" fixed-width
                        class="mr-2" />Log In</Link>

                    <Link class="text-timberwolf-50 hidden md:inline-block hover:no-underline focus:no-underline"
                        v-if="$page.props.auth.user" :href="route('creator.campaigns.index')"><font-awesome-icon
                        :icon="['fas', 'book']" fixed-width class="mr-2" />Campaigns</Link>

                    <HeaderAccountMenu v-if="$page.props.auth.user"></HeaderAccountMenu>
                </nav>
            </div>
        </div>
    </header>
</template>