<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    defineProps({
        href: { type: String, required: true },
    })
</script>
<template>
    <Link :href="href"
        class="p-4 md:py-2 block w-full hover:bg-biscay-600 focus:bg-biscay-600 text-biscay-600 dark:text-biscay-200 hover:text-timberwolf-50 focus:text-timberwolf-50 text-center md:text-left duration-0">
    <slot></slot>
    </Link>
</template>