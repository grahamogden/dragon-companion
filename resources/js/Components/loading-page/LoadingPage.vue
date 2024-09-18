<script setup lang="ts">
    import LoadingSpinner from '../loading-spinner/LoadingSpinner.vue'
    // const isLoading = defineModel('isLoading', { required: false, default: false })
    const props = defineProps<{
        isLoading?: boolean
    }>()
</script>

<template>
    <slot v-if="!isLoading" name="content"></slot>
    <loading-spinner v-else>Loading <slot name="loading-text"></slot></loading-spinner>
</template>