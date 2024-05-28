<script setup lang="ts">
    import { ref } from 'vue';
    import { type DropDownItemLinkInterface, type DropDownItemButtonInterface, DropDownItemRouter, DropDownItemButton } from '../interfaces/drop-down.item.interface';
    import { vOnClickOutside } from '@vueuse/components'

    const props = defineProps<{
        buttonLabel: string
        links: (DropDownItemLinkInterface | DropDownItemButtonInterface)[]
        buttonAriaContextName: string
    }>()

    const isMenuOpen = ref(false);

    function closeDropDownMenu(event: Event) {
        isMenuOpen.value = false
    }

    function toggleDropDownMenu() {
        isMenuOpen.value = !isMenuOpen.value
    }
</script>

<template>
    <div class="drop-down-menu-container relative" v-on-click-outside="closeDropDownMenu">
        <button :aria-expanded="isMenuOpen" @click="toggleDropDownMenu"
            :aria-label="props.buttonAriaContextName + ' menu toggle'" type="button">
            {{ props.buttonLabel }}
        </button>
        <div v-show="isMenuOpen"
            class="fixed lg:absolute bottom-28 lg:bottom-full left-1/2 lg:left-auto -translate-x-1/2 lg:translate-x-0 lg:right-0 w-3/4 min-w-20 z-30 flex flex-col bg-timberwolf-150 dark:bg-woodsmoke-900 rounded-lg lg:rounded-tr-none py-2 shadow-lg lg:shadow-md shadow-timberwolf-400 dark:shadow-woodsmoke-1000 border-timberwolf-300 dark:border-woodsmoke-700 border">
            <div v-for="link in props.links">
                <router-link v-if="link instanceof DropDownItemRouter" :to="link.destination!"
                    class="py-2 px-4 block w-full text-center lg:text-right">{{ link.label }}</router-link>
                <button v-if="link instanceof DropDownItemButton"
                    @click="link.onClickFunc.func(...link.onClickFunc.args)"
                    class="py-2 px-4 block w-full text-biscay-800 underline dark:text-biscay-300 text-center lg:text-right"
                    type="button">{{ link.label
                    }}</button>
            </div>
        </div>
    </div>
    <div v-show="isMenuOpen" class="fixed top-0 left-0 w-full h-full bg-stone-950 opacity-50 lg:hidden z-20"></div>
</template>