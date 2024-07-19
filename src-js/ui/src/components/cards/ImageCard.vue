<script setup lang="ts">
import type KebabMenu from '../dropdowns/kebab-menu/KebabMenu.vue';


const props = defineProps<{
    text: string
}>()
</script>

<template>
    <div class="w-full min-w-28 bg-timberwolf-50 bg-woodsmoke-900 rounded-xl shadow-md">
        <img class="rounded-t-xl" src="../../assets/images/background/light/full.svg">
        <div class="p-2 flex flex-row justify-between">
            <!-- {{ props.text }}
            <kebab-menu :links="getLinks(campaign)" :button-aria-context-name="'Campaign ' + text" /> -->
            <slot></slot>
        </div>
    </div>
</template>