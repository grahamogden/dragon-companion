<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';

    const props = defineProps<{
        destination: RouteLocationRaw
        widthFull?: boolean
    }>()
</script>
<template>
    <div class="inline-block bg-biscay-100 dark:bg-biscay-900 text-biscay-800 dark:text-timberwolf-50 border border-biscay-600 rounded-lg overflow-hidden transition-colors duration-theme-change"
        :class="{ 'w-full': widthFull === true }">
        <router-link :to="props.destination"
            class="w-full py-2 px-4 hover:bg-biscay-600 focus:bg-biscay-600 hover:text-timberwolf-50 focus:text-timberwolf-50 text-center no-underline duration-0">
            <slot></slot>
        </router-link>
    </div>
</template>