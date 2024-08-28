<script setup lang="ts">
    import { ref, computed } from 'vue';
    import { vOnClickOutside } from '@vueuse/components'
    import { useConfigurationStore } from '../../../stores';
    import MobileBottomMenu from '../mobile-bottom-menu/MobileBottomMenu.vue';

    const configStore = useConfigurationStore()

    const props = defineProps<{
        buttonAriaContextName: string
    }>()

    const isMenuOpen = ref(false);
    const iconClass = computed(() => isMenuOpen.value ? 'caret-up' : 'caret-down')

    function toggleKebabMenu(open?: boolean) {
        isMenuOpen.value = open ?? !isMenuOpen.value

        configStore.setOverlayActive(isMenuOpen.value)
    }
</script>

<template>
    <div class="kebab-menu-container relative inline-block align-middle">
        <div class="block relative w-max min-w-2 md:min-w-20 min-h-9">
            <div class="block md:absolute top-0 right-0 w-max bg-biscay-100 dark:bg-biscay-900 text-biscay-800 dark:text-timberwolf-50 border border-biscay-600 rounded-lg shadow-shark-300 dark:shadow-stone-950 overflow-hidden transition-colors duration-theme-change"
                :class="(isMenuOpen ? 'z-10 transition-shadow shadow-sm' : '')">
                <button @click="toggleKebabMenu()" v-on-click-outside="() => isMenuOpen && toggleKebabMenu(false)"
                    :aria-expanded="isMenuOpen" :aria-label="props.buttonAriaContextName + ' menu toggle'"
                    class="block w-full px-2 py-1 hover:bg-biscay-600 focus:bg-biscay-600 hover:text-timberwolf-50 focus:text-timberwolf-50 text-right no-underline transition-colors duration-0"
                    type="button"><span class="hidden md:inline">More </span><font-awesome-icon
                        :icon="['fas', iconClass]" fixed-width /></button>
                <div v-if="configStore.isSmallScreen()">
                    <MobileBottomMenu :is-menu-open="isMenuOpen">
                        <template #items>
                            <slot name="items"></slot>
                        </template>
                    </MobileBottomMenu>
                </div>
                <div v-else>
                    <transition name="kebab-slide-out">
                        <div class="kebab-menu md:relative md:bottom-auto md:left-auto md:translate-x-0 md:right-0 md:w-auto bg-timberwolf-50 dark:bg-woodsmoke-950 md:border-0 md:border-t border-biscay-600 md:rounded-none overflow-hidden z-40"
                            v-if="isMenuOpen">
                            <slot name="items"></slot>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>

<style>

    .kebab-slide-out-enter-from,
    .kebab-slide-out-leave-to {
        line-height: 0;
        font-size: 0;
    }

    .kebab-slide-out-enter-from a,
    .kebab-slide-out-leave-to a,
    .kebab-slide-out-enter-from button,
    .kebab-slide-out-leave-to button {
        padding: 0;
    }

    .kebab-slide-out-enter-active,
    .kebab-slide-out-leave-active,
    .kebab-slide-out-enter-active a,
    .kebab-slide-out-leave-active a,
    .kebab-slide-out-enter-active button,
    .kebab-slide-out-leave-active button {
        transition-property: padding, line-height, font-size;
        transition-duration: 0.1s;
        transition-timing-function: ease;
        transition-delay: 0ms;
    }

    .kebab-slide-out-enter-to,
    .kebab-slide-out-leave-from {
        line-height: normal;
        font-size: normal;
    }
</style>