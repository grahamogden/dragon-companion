<script setup lang="ts">
    import { ref } from 'vue';
    import { LinkInterfaceTypeEnum, type LinkInterface } from '../../components/interfaces/link-interface'

    const props = defineProps<{
        links: LinkInterface[]
        contextName: string
    }>()

    const isMenuOpen = ref(false);

    function toggleKebabMenu(event: Event) {
        isMenuOpen.value = !isMenuOpen.value
    }
</script>

<template>
    <div class="kebab-menu-container relative">
        <button @click="toggleKebabMenu" class="text-xl px-2" :aria-expanded="isMenuOpen" :aria-label="props.contextName + ' menu toggle'"
            type="button">
            <!-- <img class="w-6" src="/src/assets/images/kebab-menu-icon.svg" :alt="props.contextName + ' menu toggle icon'" /> -->
                &#8942;
            </button>
        <div v-show="isMenuOpen"
            class="kebab-menu absolute right-0 top-full flex flex-col bg-parchment-pale dark:bg-leather-brown rounded-md py-2 border border-leather-brown shadow-sm shadow-orange-950 z-10 text-left">
            <div v-for="link in props.links">
                <router-link v-if="link.type === LinkInterfaceTypeEnum.ROUTER" :to="link.destination!"
                    class="py-2 px-4 block">{{ link.label }}</router-link>
                <button v-if="link.type === LinkInterfaceTypeEnum.BUTTON"
                    @click="link.function!.func(...link.function!.args)"
                    class="py-2 px-4 block underline text-bright-blue dark:text-light-blue" type="button">{{ link.label
                    }}</button>
            </div>
        </div>
    </div>
</template>
