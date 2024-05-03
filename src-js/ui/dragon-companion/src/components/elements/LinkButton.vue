<script setup lang="ts">
import type { RouteLocationRaw } from 'vue-router';

const props = defineProps<{
    text: string
    destination: RouteLocationRaw
}>()
</script>
<template>
    <div class="w-full mb-4 inline-block">
        <router-link :to="props.destination"
            class="stitching py-2 px-4 border-4 border-leather-brown rounded text-leather-brown dark:text-parchment-pale font-bold min-w-48 relative text-center no-underline w-full">{{
            props.text }}</router-link>
    </div>
</template>