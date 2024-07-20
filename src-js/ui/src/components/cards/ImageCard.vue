<script setup lang="ts">
    import type KebabMenu from '../dropdowns/kebab-menu/KebabMenu.vue';


    const props = defineProps<{
        text: string,
        isSelected?: boolean,
    }>()
</script>

<template>
    <div class="w-full min-w-28 border-saffron-mango-300 rounded-xl shadow-md shadow-shark-300 dark:shadow-stone-950 transition-colors transition-shadow duration-500"
        :class="props.isSelected ? 'border-8' : ''">
        <img :class="props.isSelected ? 'rounded-t-sm' : 'rounded-t-xl'"
            src="../../assets/images/background/light/full.svg">
        <div class="p-2 flex flex-row justify-between">
            <!-- {{ props.text }}
            <kebab-menu :links="getLinks(campaign)" :button-aria-context-name="'Campaign ' + text" /> -->
            <slot></slot>
        </div>
    </div>
</template>