<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    defineProps({
        href: { type: String, required: true },
        isDestructive: { type: Boolean, required: false }
    })
</script>
<template>
    <Link :href="href"
        class="p-4 md:py-2 block w-full hover:bg-biscay-600 focus:bg-biscay-600 text-biscay-600 dark:text-biscay-200 hover:text-timberwolf-50 focus:text-timberwolf-50 text-center md:text-left underline hover:no-underline duration-0"
        :class="isDestructive ? 'hover:bg-red-600 focus:bg-red-600' : 'hover:bg-biscay-600 focus:bg-biscay-600 dark:text-biscay-200 hover:text-timberwolf-50 focus:text-timberwolf-50'">
    <slot></slot>
    </Link>
</template>