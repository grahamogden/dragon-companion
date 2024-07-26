<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';

    const props = defineProps<{
        destination: RouteLocationRaw
    }>()
</script>
<template>
    <div
        class="inline-block bg-timberwolf-50 dark:bg-woodsmoke-950 transition-colors border border-biscay-600 dark:border-biscay-200 rounded-xl overflow-hidden duration-500">
        <router-link :to="props.destination"
            class="py-2 px-4 text-biscay-600 hover:text-timberwolf-50 dark:text-biscay-200 dark:hover:text-woodsmoke-950 hover:bg-biscay-600 dark:hover:bg-biscay-200 text-center no-underline">
            <slot></slot>
        </router-link>
    </div>
</template>