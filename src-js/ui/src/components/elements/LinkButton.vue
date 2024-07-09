<script setup lang="ts">
import type { RouteLocationRaw } from 'vue-router';

const props = defineProps<{
    destination: RouteLocationRaw
}>()
</script>
<template>
    <!-- <div :class="'w-full mb-4 inline-block md:w-auto ' + orderClass"> -->
        <router-link :to="props.destination"
            class="button"><slot></slot></router-link>
    <!-- </div> -->
</template>