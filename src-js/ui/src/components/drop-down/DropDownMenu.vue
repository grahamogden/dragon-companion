<script setup lang="ts">
    import { ref } from 'vue';
    import { vOnClickOutside } from '@vueuse/components'
    import { useConfigurationStore } from '../../stores';

    const configStore = useConfigurationStore()

    const props = defineProps<{
        buttonAriaContextName: string
    }>()

    const isMenuOpen = ref(false);

    function toggleDropDownMenu(open?: boolean) {
        isMenuOpen.value = open ?? !isMenuOpen.value
        configStore.setOverlayActive(isMenuOpen.value)
        if (isMenuOpen.value) {
            menuOpened()
        } else {
            menuClosed()
        }
    }

    const emit = defineEmits(['menuOpened', 'menuClosed'])
    function menuOpened() {
        emit('menuOpened')
    }
    function menuClosed() {
        emit('menuClosed')
    }
</script>

<template>
    <div class="drop-down-menu-container relative" v-on-click-outside="() => isMenuOpen && toggleDropDownMenu(false)">
        <button :aria-expanded="isMenuOpen" @click="toggleDropDownMenu()"
            :aria-label="props.buttonAriaContextName + ' menu toggle'" type="button">
            <slot name="button-content"></slot>
        </button>
        <transition name="drop-down-menu-slide-out">
            <div v-if="isMenuOpen"
                class="drop-down-menu fixed md:absolute bottom-28 md:bottom-auto md:top-full left-1/2 md:left-auto md:right-0 w-11/12 md:w-max mt-2 z-40 origin-bottom md:origin-top-right">
                <div
                    class="flex flex-col bg-timberwolf-50 dark:bg-woodsmoke-950 border border-biscay-600 rounded-xl overflow-hidden transition-colors-and-shadows duration-theme-change">
                    <slot name="items"></slot>
                </div>
            </div>
        </transition>
    </div>
</template>

<style>

    .drop-down-menu {
        transform: translateX(-50%);
    }

    .drop-down-menu-slide-out-enter-from,
    .drop-down-menu-slide-out-leave-to {
        transform: translateX(-50%) scale(1, 0);
    }

    .drop-down-menu-slide-out-enter-active,
    .drop-down-menu-slide-out-leave-active {
        transition-property: transform;
        transition-duration: 0.1s;
        transition-timing-function: ease-in-out;
        transition-delay: 0ms;
    }

    .drop-down-menu-slide-out-enter-to,
    .drop-down-menu-slide-out-leave-from {
        transform: translateX(-50%) scale(1, 1);
    }

    @media all and (min-width: 768px) {

        .drop-down-menu {
            transform: translateX(0);
        }

        .drop-down-menu-slide-out-enter-from,
        .drop-down-menu-slide-out-leave-to {
            transform: translateX(0) scale(0);
        }

        .drop-down-menu-slide-out-enter-active,
        .drop-down-menu-slide-out-leave-active {
            transition-property: transform;
            transition-duration: 0.1s;
            transition-timing-function: ease-in-out;
            transition-delay: 0ms;
        }

        .drop-down-menu-slide-out-enter-to,
        .drop-down-menu-slide-out-leave-from {
            transform: translateX(0) scale(1);
        }
    }

    /* .drop-down-menu-slide-out-enter-from,
    .drop-down-menu-slide-out-leave-to {
        line-height: 0;
        font-size: 0;
    }

    .drop-down-menu-slide-out-enter-from *,
    .drop-down-menu-slide-out-leave-to * {
        padding: 0;
    }

    .drop-down-menu-slide-out-enter-active,
    .drop-down-menu-slide-out-leave-active,
    .drop-down-menu-slide-out-enter-active *,
    .drop-down-menu-slide-out-leave-active * {
        transition-property: padding, line-height, font-size;
        transition-duration: 0.1s;
        transition-timing-function: ease;
        transition-delay: 0ms;
    }

    .drop-down-menu-slide-out-enter-to,
    .drop-down-menu-slide-out-leave-from {
        line-height: normal;
        font-size: normal;
    } */
</style>