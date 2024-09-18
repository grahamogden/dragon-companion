<script setup lang="ts">
    import { useConfigurationStore } from '../../../stores';


    const configStore = useConfigurationStore()

    const props = defineProps<{
        isMenuOpen: boolean
    }>()

</script>

<template>
    <transition name="mobile-bottom-slide-out" v-if="configStore.isSmallScreen()">
        <div class="mobile-bottom-menu fixed md:relative bottom-28 md:bottom-auto left-1/2 md:left-auto -translate-x-1/2 md:translate-x-0 md:right-0 w-11/12 md:w-auto flex flex-col bg-timberwolf-50 dark:bg-woodsmoke-950 border md:border-0 md:border-t border-biscay-600 rounded-xl md:rounded-none overflow-hidden z-40"
            v-if="isMenuOpen">
            <slot name="items"></slot>
        </div>
    </transition>
</template>

<style>

    .mobile-bottom-slide-out-enter-from,
    .mobile-bottom-slide-out-leave-to {
        line-height: 0;
        font-size: 0;
    }

    .mobile-bottom-slide-out-enter-from *,
    .mobile-bottom-slide-out-leave-to * {
        padding: 0;
    }

    .mobile-bottom-slide-out-enter-active,
    .mobile-bottom-slide-out-leave-active,
    .mobile-bottom-slide-out-enter-active *,
    .mobile-bottom-slide-out-leave-active * {
        transition-property: padding, line-height, font-size;
        transition-duration: 0.1s;
        transition-timing-function: ease;
        transition-delay: 0ms;
    }

    .mobile-bottom-slide-out-enter-to,
    .mobile-bottom-slide-out-leave-from {
        line-height: normal;
        font-size: normal;
    }
</style>