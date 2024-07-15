<script setup lang="ts">
import type { RouteLocationRaw } from 'vue-router';

const props = defineProps<{
    destination: RouteLocationRaw
}>()
</script>
<template>
    <!-- <div :class="'w-full mb-4 inline-block md:w-auto ' + orderClass"> -->
        <router-link :to="props.destination"
            class="py-2 px-4 w-full min-w-48 md:w-auto text-white-lilac-800 hover:text-timberwolf-50 dark:text-white-lilac-200 dark:hover:text-woodsmoke-950 bg-white-lilac-100 hover:bg-white-lilac-800 dark:bg-woodsmoke-950 dark:hover:bg-white-lilac-200 rounded-xl border border-white-lilac-800 dark:border-white-lilac-200 text-center no-underline"><slot></slot></router-link>
    <!-- </div> -->
</template>