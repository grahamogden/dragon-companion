<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';
    import LinkButton from '../buttons/LinkButton.vue';

    const props = defineProps<{
        linkText?: string
        linkDestination?: RouteLocationRaw
    }>()
</script>
<template>
    <div class="flex flex-row justify-between items-center mb-4 px-4">
        <h1 class="duration-500">
            <slot></slot>
        </h1>
        <link-button v-if="props.linkText && props.linkDestination" :destination="props.linkDestination">{{
            props.linkText }}</link-button>
    </div>
</template>