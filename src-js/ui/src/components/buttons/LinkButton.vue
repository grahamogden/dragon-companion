<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';

    const props = defineProps<{
        destination: RouteLocationRaw
    }>()
</script>
<template>
    <!-- <div
        class="inline-block bg-timberwolf-50 dark:bg-woodsmoke-950 transition-colors border border-biscay-600 dark:border-biscay-200 rounded-lg overflow-hidden duration-theme-change">
        <router-link :to="props.destination"
            class="py-2 px-4 text-biscay-600 hover:text-timberwolf-50 dark:text-biscay-200 dark:hover:text-woodsmoke-950 hover:bg-biscay-600 dark:hover:bg-biscay-200 text-center no-underline">
            <slot></slot>
        </router-link>
    </div> -->
    <div
        class="inline-block bg-biscay-100 dark:bg-biscay-900 border border-biscay-600 rounded-lg overflow-hidden transition-colors duration-theme-change">
        <router-link :to="props.destination"
            class="py-2 px-4 hover:bg-biscay-600 focus:bg-biscay-600 text-biscay-800 dark:text-timberwolf-50 hover:text-timberwolf-50 focus:text-timberwolf-50 text-center no-underline duration-0">
            <slot></slot>
        </router-link>
    </div>
</template>