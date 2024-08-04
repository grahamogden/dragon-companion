<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';

    const props = defineProps<{
        destination: RouteLocationRaw
    }>()
</script>

<template>
    <router-link
        class="hover:no-underline focus:no-underline focus:underline py-3 px-4 hover:lg:pl-8 focus:lg:pl-8 bg-transparent hover:bg-timberwolf-50 focus:bg-timberwolf-50 text-woodsmoke-950 dark:text-timberwolf-50 hover:text-shark-950 focus:text-shark-950 transition-all duration-300"
        :to="props.destination">
        <slot></slot>
    </router-link>
</template>