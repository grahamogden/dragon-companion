<script setup lang="ts">
    import { ref, watch } from 'vue'
    import { useConfigurationStore, ThemeEnum } from '../stores/index'
    import LoadingSpinner from '../Components/loading-spinner/LoadingSpinner.vue'
    import ToolbarNavigation from '../Components/navigation/ToolbarNavigation.vue'
    import HeaderAccountMenu from '../Components/header/account/HeaderAccountMenu.vue'
    import { Link } from '@inertiajs/vue3'
    import Header from './Header.vue'

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

    // const layout = computed(() => {
    //     switch () {
    //         case 'CreatorDashboard':
    //             return CreatorDashboard
    //         case 'Home':
    //             return Home
    //         case 'SlimSimpleContainerLayout':
    //             return SimpleContainerSlimLayout
    //         default:
    //             return SimpleContainerLayout
    //     }
    // })
    // const layout = SimpleContainerLayout;

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

    // watch(
    //     () => route.path,
    //     () => {
    //         skipLinkReset.value.focus()
    //     }
    // )
</script>
<template>
    <div class="relative flex flex-col">
        <a tabindex="-1" ref="skipLinkReset" class="absolute"></a>
        <a href="#main-content"
            class="absolute z-30 focus:p-4 focus:underline max-h-0 focus:max-h-none bg-white-lilac-50 dark:bg-shark-950 overflow-hidden"
            ref="skipLink">Skip to main content</a>

        <Header></Header>

        <!-- <component :is="layout"> -->
        <Suspense>
            <slot></slot>
            <template #fallback>
                <loading-spinner />
            </template>
        </Suspense>
        <!-- </component> -->

        <ToolbarNavigation></ToolbarNavigation>

        <div v-if="configStore.isOverlayActive" @click="configStore.setOverlayActive(false)"
            class="fixed top-0 left-0 w-full h-full bg-stone-950 opacity-50 md:hidden"></div>
    </div>
</template>