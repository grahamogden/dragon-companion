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
    <div class="kebab-menu-container relative inline-block" v-on-click-outside="closeDropDownMenu">
        <div class="relative flex h-auto">
            <div
                class="inline-block relative w-max bg-timberwolf-50 dark:bg-woodsmoke-950 border border-biscay-600 dark:border-biscay-200 rounded-xl overflow-hidden transition-colors duration-500">
                <button @click="toggleKebabMenu" :aria-expanded="isMenuOpen"
                    :aria-label="props.buttonAriaContextName + ' menu toggle'"
                    class="px-2 py-1 text-biscay-600 hover:text-timberwolf-50 dark:text-biscay-200 dark:hover:text-woodsmoke-950 hover:bg-biscay-600 dark:hover:bg-biscay-200 no-underline transition-colors duration-0"
                    type="button"><span class="hidden lg:inline">More </span>&#8942;</button>
            </div>
            <div v-show="isMenuOpen"
                class="kebab-menu fixed lg:absolute bottom-28 lg:bottom-auto top-auto lg:top-full left-1/2 lg:left-auto -translate-x-1/2 lg:translate-x-0 lg:right-0 w-3/4 lg:w-auto lg:min-w-20 z-30 flex flex-col bg-shark-100 dark:bg-woodsmoke-900 rounded-lg border border-biscay-600 dark:border-biscay-200 shadow-lg lg:shadow-md shadow-shark-900 dark:shadow-woodsmoke-1000 text-center lg:text-left overflow-hidden">
                <div v-for="link in props.links">
                    <router-link v-if="link instanceof DropDownItemRouter" :to="link.destination!"
                        class="py-4 lg:py-2 px-6 block w-full text-biscay-600 hover:text-timberwolf-50 dark:text-biscay-200 dark:hover:text-woodsmoke-950 hover:bg-biscay-600 dark:hover:bg-biscay-200"
                        @click="toggleKebabMenu">{{ link.label }}</router-link>
                    <button v-if="link instanceof DropDownItemButton"
                        @click="toggleKebabMenu(); link.onClickFunc!.func(...link.onClickFunc!.args)"
                        class="py-4 lg:py-2 px-6 block w-full text-biscay-600 hover:text-timberwolf-50 dark:text-biscay-200 dark:hover:text-woodsmoke-950 hover:bg-biscay-600 dark:hover:bg-biscay-200 border-0 underline hover:no-underline"
                        type="button">{{ link.label
                        }}</button>
                </div>
            </div>
        </div>
    </div>
    <div v-show="isMenuOpen" class="fixed top-0 left-0 w-full h-full bg-stone-950 opacity-50 lg:hidden z-20"></div>
</template>