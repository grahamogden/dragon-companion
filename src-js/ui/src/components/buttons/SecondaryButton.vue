<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';

    const props = defineProps<{
        // destination: RouteLocationRaw
        func: Function
        args: Array<any>
    }>()
</script>
<template>
    <div
        class="inline-block w-full md:w-auto bg-biscay-100 dark:bg-biscay-900 border border-biscay-600 rounded-lg overflow-hidden transition-colors duration-theme-change">
        <button
            class="relative w-full min-w-48 md:w-auto py-2 px-4 hover:bg-biscay-600 focus:bg-biscay-600 text-biscay-800 dark:text-timberwolf-50 hover:text-timberwolf-50 focus:text-timberwolf-50 text-center no-underline duration-0"
            type="submit" @click="func(...args)">
            <slot>Submit</slot>
        </button>
    </div>

    <!-- <router-link :to="props.destination"
        class="py-2 px-4 w-full min-w-48 md:w-auto bg-biscay-100 hover:bg-biscay-600 dark:bg-woodsmoke-950 dark:hover:bg-biscay-200 rounded-lg border border-biscay-600 dark:border-biscay-200 text-biscay-600 hover:text-timberwolf-50 dark:text-biscay-200 dark:hover:text-woodsmoke-950 text-center no-underline duration-theme-change">
        <slot></slot>
    </router-link> -->
</template>