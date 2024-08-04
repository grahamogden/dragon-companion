<script setup lang="ts">
    import { ref } from 'vue';
    import { type DropDownItemLinkInterface, type DropDownItemButtonInterface, DropDownItemRouter, DropDownItemButton } from '../../interfaces/drop-down.item.interface';
    import { vOnClickOutside } from '@vueuse/components'

    const props = defineProps<{
        links: (DropDownItemLinkInterface | DropDownItemButtonInterface)[]
        buttonAriaContextName: string
    }>()

    const isMenuOpen = ref(false);

    function closeDropDownMenu(event: Event) {
        isMenuOpen.value = false
    }

    function toggleKebabMenu() {
        isMenuOpen.value = !isMenuOpen.value
    }
</script>

<template>
    <div class="kebab-menu-container relative inline-block align-middle" v-on-click-outside="closeDropDownMenu">
        <div class="block relative w-max min-w-2 md:min-w-20 min-h-9">
            <div class="block md:absolute top-0 right-0 w-max bg-biscay-100 dark:bg-biscay-900 border border-biscay-600 rounded-xl shadow-shark-300 dark:shadow-stone-950 overflow-hidden transition-colors duration-theme-change"
                :class="(isMenuOpen ? 'z-10 transition-shadow shadow-sm' : '')">
                <button @click="toggleKebabMenu" :aria-expanded="isMenuOpen"
                    :aria-label="props.buttonAriaContextName + ' menu toggle'"
                    class="block w-full px-2 py-1 hover:bg-biscay-600 focus:bg-biscay-600 text-biscay-800 dark:text-timberwolf-50 hover:text-timberwolf-50 focus:text-timberwolf-50 text-right no-underline transition-colors duration-0"
                    type="button"><span class="hidden md:inline">More </span>&#8942;</button>
                <transition name="kebab-slide-out">
                    <div class="kebab-menu fixed md:relative bottom-28 md:bottom-auto left-1/2 md:left-auto -translate-x-1/2 md:translate-x-0 md:right-0 w-3/4 md:w-auto bg-timberwolf-50 dark:bg-woodsmoke-950 border md:border-0 md:border-t border-biscay-600 rounded-xl md:rounded-none overflow-hidden z-40"
                        v-show="isMenuOpen">
                        <div v-for="link in props.links">
                            <router-link v-if="(link instanceof DropDownItemRouter)" :to="link.destination!"
                                class="p-4 md:py-2 block w-full hover:bg-biscay-600 focus:bg-biscay-600 text-biscay-600 dark:text-biscay-200 hover:text-timberwolf-50 focus:text-timberwolf-50 text-center md:text-right duration-0"
                                @click="toggleKebabMenu">{{ link.label }}</router-link>
                            <button v-if="(link instanceof DropDownItemButton)"
                                @click="toggleKebabMenu(); link.onClickFunc!.func(...link.onClickFunc!.args)"
                                class="p-4 md:py-2 block w-full text-biscay-600 hover:text-timberwolf-50 focus:text-timberwolf-50 dark:text-biscay-200 border-0 text-center md:text-right underline hover:no-underline duration-focus:no-underline duration-0"
                                :class="link.isDestructive ? 'hover:bg-red-600 focus:bg-red-600' : 'hover:bg-biscay-600 focus:bg-biscay-600 dark:text-biscay-200 hover:text-timberwolf-50 focus:text-timberwolf-50'"
                                type="button">{{ link.label
                                }}</button>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
    <div v-if="isMenuOpen" class="fixed top-0 left-0 w-full h-full bg-stone-950 opacity-50 md:hidden z-30"></div>
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