<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';

    const props = defineProps<{
        destination: RouteLocationRaw
    }>()
</script>
<template>
    <!-- <div :class="'w-full mb-4 inline-block md:w-auto ' + orderClass"> -->
    <router-link :to="props.destination"
        class="py-2 px-4 w-full min-w-48 md:w-auto text-biscay-600 hover:text-timberwolf-50 dark:text-biscay-200 dark:hover:text-woodsmoke-950 bg-biscay-100 hover:bg-biscay-600 dark:bg-woodsmoke-950 dark:hover:bg-biscay-200 rounded-xl border border-biscay-600 dark:border-biscay-200 text-center no-underline">
        <slot></slot>
    </router-link>
    <!-- </div> -->
</template>