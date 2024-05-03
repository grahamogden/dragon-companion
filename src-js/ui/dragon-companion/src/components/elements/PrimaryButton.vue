<script setup lang="ts">
const props = defineProps<{
    text: string
}>()
</script>
<template>
    <div class="w-full mb-4 inline-block">
        <button
            class="stitching py-2 px-4 border-4 border-leather-brown rounded bg-leather-brown bg-leather-texture bg-left-top bg-repeat text-parchment-pale font-bold min-w-48 relative text-center no-underline w-full"
            type="submit">{{ props.text }}</button>
    </div>
</template>