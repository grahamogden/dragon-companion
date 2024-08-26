<script setup lang="ts">
    const props = defineProps<{
        func: Function
        args: any[]
        isDestructive?: boolean | { type: boolean, default: false }
    }>()
</script>
<template>
    <button @click="props.func(...props.args)"
        class="p-4 md:py-2 block w-full text-biscay-600 hover:text-timberwolf-50 focus:text-timberwolf-50 dark:text-biscay-200 border-0 text-center md:text-left underline hover:no-underline duration-focus:no-underline duration-0"
        :class="props.isDestructive ? 'hover:bg-red-600 focus:bg-red-600' : 'hover:bg-biscay-600 focus:bg-biscay-600 dark:text-biscay-200 hover:text-timberwolf-50 focus:text-timberwolf-50'"
        type="button">
        <slot></slot>
    </button>
</template>