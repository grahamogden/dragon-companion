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
    <div class="kebab-menu-container relative" v-on-click-outside="closeDropDownMenu">
        <button @click="toggleKebabMenu" :aria-expanded="isMenuOpen"
            :aria-label="props.buttonAriaContextName + ' menu toggle'" class="px-2 py-1 text-white-lilac-800 hover:text-timberwolf-50 dark:text-white-lilac-200 dark:hover:text-woodsmoke-950 bg-timberwolf-50 hover:bg-white-lilac-800 dark:bg-woodsmoke-950 dark:hover:bg-white-lilac-200 no-underline border border-white-lilac-800 dark:border-white-lilac-200 rounded-xl" type="button">
            <span class="hidden lg:inline">More </span>&#8942;
        </button>
        <div v-show="isMenuOpen"
            class="kebab-menu fixed lg:absolute bottom-28 lg:bottom-auto top-auto lg:top-full left-1/2 lg:left-auto -translate-x-1/2 lg:translate-x-0 lg:right-0 w-3/4 lg:w-auto lg:min-w-20 z-30 flex flex-col bg-shark-100 dark:bg-woodsmoke-800 rounded-lg border border-shark-300 dark:border-woodsmoke-700 shadow-lg lg:shadow-md shadow-shark-900 dark:shadow-woodsmoke-1000 text-center lg:text-left overflow-hidden">
            <div v-for="link in props.links">
                <router-link v-if="link instanceof DropDownItemRouter" :to="link.destination!"
                    class="py-4 lg:py-2 px-6 block w-full hover:bg-woodsmoke-950/20 focus:bg-woodsmoke-950/20" @click="toggleKebabMenu">{{ link.label }}</router-link>
                <button v-if="link instanceof DropDownItemButton"
                    @click="toggleKebabMenu(); link.onClickFunc!.func(...link.onClickFunc!.args)"
                    class="py-4 lg:py-2 px-6 block w-full text-white-lilac-800 dark:text-white-lilac-200 border-0 hover:bg-woodsmoke-950/20 focus:bg-woodsmoke-950/20 underline hover:no-underline" type="button">{{ link.label
                    }}</button>
            </div>
        </div>
    </div>
    <div v-show="isMenuOpen" class="fixed top-0 left-0 w-full h-full bg-stone-950 opacity-50 lg:hidden z-20"></div>
</template>