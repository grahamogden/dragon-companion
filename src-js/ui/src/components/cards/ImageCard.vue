<script setup lang="ts">
    import type KebabMenu from '../dropdowns/kebab-menu/KebabMenu.vue';


    const props = defineProps<{
        text: string,
        isSelected?: boolean,
    }>()
</script>

<template>
    <div
        class="w-full rounded-xl shadow-sm shadow-shark-500 dark:shadow-stone-950 transition-colors transition-shadow duration-theme-change">
        <div class="relative rounded-t-xl overflow-hidden border-0 border-b-0"
            :class="props.isSelected ? 'border-saffron-mango-300' : 'border-timberwolf-200 dark:border-woodsmoke-800'">
            <img src="../../assets/images/background/light/full.svg">
            <div class="absolute top-0 left-0 border-[2rem] border-transparent border-l-saffron-mango-300 border-t-saffron-mango-300"
                :class="props.isSelected ? 'block' : 'hidden'">
            </div>
        </div>
        <div class="p-2 flex flex-row grow justify-between rounded-b-xl border-0 border-t-0">
            <!-- {{ props.text }}
            <kebab-menu :links="getLinks(campaign)" :button-aria-context-name="'Campaign ' + text" /> -->
            <slot></slot>
        </div>
    </div>
</template>