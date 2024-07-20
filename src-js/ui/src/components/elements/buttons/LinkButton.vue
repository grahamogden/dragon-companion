<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';

    const props = defineProps<{
        destination: RouteLocationRaw
    }>()
</script>
<template>
    <div
        class="inline-block bg-timberwolf-50 dark:bg-woodsmoke-950 transition-colors border border-white-lilac-800 dark:border-white-lilac-200 rounded-xl overflow-hidden duration-500">
        <router-link :to="props.destination"
            class="py-2 px-4 text-white-lilac-800 hover:text-timberwolf-50 dark:text-white-lilac-200 dark:hover:text-woodsmoke-950 hover:bg-white-lilac-800 dark:hover:bg-white-lilac-200 text-center no-underline">
            <slot></slot>
        </router-link>
    </div>
</template>