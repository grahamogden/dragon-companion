<script setup lang="ts">
    import { nextTick, ref } from 'vue';
    import { vOnClickOutside } from '@vueuse/components'
    import { useConfigurationStore } from '../../stores';
    import Button from '../buttons/Button.vue';

    const configStore = useConfigurationStore()

    const props = defineProps({
        buttonAriaContextName: String,
        closeOnClick: { type: Boolean, default: true },
    })

    const isMenuOpen = ref(false);
    const coordinates = ref({ x: 'auto', y: 'auto' })
    const dropDownMenu = ref<HTMLDivElement | null>(null)

    function toggleDropDownMenu(event: Event | null, open?: boolean) {
        isMenuOpen.value = open ?? !isMenuOpen.value
        configStore.setOverlayActive(isMenuOpen.value)
        if (isMenuOpen.value) {
            const targetElement: HTMLDivElement | null | undefined = event?.target as HTMLDivElement | null ?? null
            const element: HTMLDivElement | null | undefined = targetElement?.closest('.drop-down-menu-container')
            if (element) {
                const rect = element.getBoundingClientRect()
                coordinates.value.y = configStore.isSmallScreen() ? 'auto' : rect.bottom + 'px'
                nextTick(() => {
                    const menuWidth = dropDownMenu.value?.getBoundingClientRect().width ?? 0;

                    if (configStore.isSmallScreen()) {
                        coordinates.value.x = '50%'
                    } else {
                        coordinates.value.x = (rect.right - menuWidth) > 0 ? (rect.right - menuWidth) + 'px' : '0'
                    }
                })
            }
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
    <div class="drop-down-menu-container relative"
        v-on-click-outside="() => isMenuOpen && toggleDropDownMenu(null, false)">
        <slot name="button-content">
            <Button :aria-expanded="isMenuOpen" @click="toggleDropDownMenu"
                :aria-label="props.buttonAriaContextName + ' menu toggle'" type="button" rounded>
                <font-awesome-icon :icon="['fas', 'ellipsis-vertical']" fixed-width class="text-lg"></font-awesome-icon>
            </Button>
        </slot>
        <Teleport to="body">
            <Transition name="drop-down-menu-slide-out">
                <div v-show="isMenuOpen" ref="dropDownMenu"
                    class="drop-down-menu fixed bottom-28 md:bottom-auto w-11/12 md:w-max mt-2 z-50 origin-bottom md:origin-top-right flex flex-col bg-timberwolf-50 dark:bg-woodsmoke-950 border border-shark-300 rounded-xl overflow-hidden shadow-md shadow-stone-900/10"
                    :style="'top:' + coordinates.y + ';left:' + coordinates.x + ';'"
                    @click="closeOnClick && toggleDropDownMenu(null, false)">
                    <slot name="items"></slot>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<style>

    /* .drop-down-menu {
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
    } */

    @media all and (max-width: 767px) {
        .drop-down-menu {
            transform: translate(-50%, 0);
        }

        .drop-down-menu-slide-out-enter-from,
        .drop-down-menu-slide-out-leave-to {
            opacity: 0;
            transform: translate(-50%, 100%);
        }

        /* .drop-down-menu-slide-out-enter-to,
        .drop-down-menu-slide-out-leave-from {
            opacity: 1;
            transform: translate(-50%, 0%);
        } */
    }

    .drop-down-menu-slide-out-enter-active,
    .drop-down-menu-slide-out-leave-active {
        transition: transform opacity;
        transition-duration: 0.15s;
        transition-timing-function: linear;
        transition-delay: 0;
    }

    @media all and (min-width: 768px) {

        .drop-down-menu-slide-out-enter-from,
        .drop-down-menu-slide-out-leave-to {
            opacity: 0;
            transform: scaleY(0);
        }

        /* .drop-down-menu-slide-out-enter-to,
        .drop-down-menu-slide-out-leave-from {
            opacity: 1;
            transform: scaleY(1);
        } */

        /* .drop-down-menu-slide-out-enter-active,
        .drop-down-menu-slide-out-leave-active {
            transition: all;
            transition-duration: 1s;
            transition-timing-function: linear;
            transition-delay: 0;
        } */

        /* .drop-down-menu {
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
        } */
    }
</style>