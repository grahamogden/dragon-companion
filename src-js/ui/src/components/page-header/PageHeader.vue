<script setup lang="ts">
    import type { RouteLocationRaw } from 'vue-router';
    import LinkButton from '../buttons/LinkButton.vue';

    const props = defineProps<{
        linkText?: string
        linkDestination?: RouteLocationRaw
    }>()
</script>
<template>
    <div class="flex flex-row justify-between items-center mb-6">
        <h1 class="pb-1 border-b-2 border-shark-950 dark:border-white-lilac-50 text-xl font-bold duration-500">
            <slot></slot>
        </h1>
        <link-button v-if="props.linkText && props.linkDestination" :destination="props.linkDestination">{{
            props.linkText }}</link-button>
    </div>
</template>