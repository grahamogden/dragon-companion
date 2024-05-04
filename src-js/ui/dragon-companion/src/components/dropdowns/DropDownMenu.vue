<script setup lang="ts">
    import { ref } from 'vue';
    import { DropDownItemTypeEnum, type DropDownItemLinkInterface, type DropDownItemButtonInterface } from '../interfaces/drop-down.item.interface';

    const props = defineProps<{
        buttonLabel: string
        links: (DropDownItemLinkInterface | DropDownItemButtonInterface)[]
        buttonAriaContextName: string
    }>()

    const isMenuOpen = ref(false);

    function toggleDropDownMenu() {
        isMenuOpen.value = !isMenuOpen.value
    }

    console.debug(props.links[0])
</script>

<template>
    <div class="drop-down-menu-container relative">
        <button @click="toggleDropDownMenu" :aria-expanded="isMenuOpen"
            :aria-label="props.buttonAriaContextName + ' menu toggle'" type="button">
            {{ props.buttonLabel }}
        </button>
        <div v-show="isMenuOpen"
            class="kebab-menu absolute right-0 top-full flex flex-col bg-parchment-pale dark:bg-leather-brown rounded-md py-2 border border-leather-brown shadow-sm shadow-orange-950 z-10 text-left">
            <div v-for="link in props.links">
                <router-link v-if="link.type === DropDownItemTypeEnum.ROUTER" :to="link.destination!"
                    class="py-2 px-4 block" @click="toggleDropDownMenu">{{ link.label }}</router-link>
                <button v-if="link.type === DropDownItemTypeEnum.BUTTON"
                    @click="toggleDropDownMenu(); link.onClickFunc!.func(...link.onClickFunc!.args)"
                    class="py-2 px-4 block underline text-bright-blue dark:text-light-blue" type="button">{{ link.label
                    }}</button>
            </div>
        </div>
    </div>
</template>