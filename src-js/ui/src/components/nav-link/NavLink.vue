<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';

    const props = defineProps<{
        destination: RouteLocationRaw
    }>()
</script>

<template>
    <router-link
        class="no-underline hover:underline focus:underline py-3 px-4 hover:lg:pl-8 focus:lg:pl-8 text-timberwolf-50 bg-transparent hover:text-shark-950 focus:text-shark-950 hover:bg-timberwolf-50 focus:bg-timberwolf-50 duration-300"
        :to="props.destination">
        <slot></slot>
    </router-link>
</template>