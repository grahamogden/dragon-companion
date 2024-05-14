<script setup lang="ts">
import type { RouteLocationRaw } from 'vue-router';

const props = defineProps<{
    text: string
    destination: RouteLocationRaw
}>()
</script>
<template>
    <!-- <div :class="'w-full mb-4 inline-block md:w-auto ' + orderClass"> -->
        <router-link :to="props.destination"
            class="stitching py-2 px-4 mb-4 md:mb-0 border-4 border-leather-brown rounded text-leather-brown dark:text-parchment-pale font-bold min-w-48 relative text-center no-underline w-full md:w-auto md:min-w-48">{{
            props.text }}</router-link>
    <!-- </div> -->
</template>