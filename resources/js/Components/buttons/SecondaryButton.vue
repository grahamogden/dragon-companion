<script setup lang="ts">
    const props = defineProps<{
        func: Function
        args: Array<any>
        isDestructive?: boolean | { type: boolean, default: false }
    }>()
</script>
<template>
    <div class="inline-block w-full md:w-auto border rounded-lg overflow-hidden transition-colors duration-theme-change"
        :class="props.isDestructive ? 'bg-red-200 dark:bg-red-900 border-red-600' : 'bg-biscay-100 dark:bg-biscay-900 border-biscay-600'">
        <button
            class="relative w-full min-w-48 md:w-auto py-2 px-4 hover:text-timberwolf-50 focus:text-timberwolf-50 text-center no-underline duration-0"
            :class="props.isDestructive ? 'hover:bg-red-600 focus:bg-red-600' : 'hover:bg-biscay-600 focus:bg-biscay-600 text-biscay-800 dark:text-timberwolf-50 dark:text-biscay-200'"
            type="submit" @click.prevent="func(...args)">
            <slot>Submit</slot>
        </button>
    </div>
</template>