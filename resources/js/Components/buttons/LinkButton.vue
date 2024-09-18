<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    defineProps({
        href: { type: String, required: true },
        widthFull: { type: Boolean, required: false },
    })
</script>
<template>
    <div class="inline-block bg-biscay-100 dark:bg-biscay-900 text-biscay-800 dark:text-timberwolf-50 border border-biscay-600 rounded-lg overflow-hidden transition-colors duration-theme-change"
        :class="{ 'w-full': widthFull === true }">
        <Link :href="href"
            class="inline-block w-full py-2 px-4 hover:bg-biscay-600 focus:bg-biscay-600 hover:text-timberwolf-50 focus:text-timberwolf-50 text-center no-underline duration-0">
        <slot></slot>
        </Link>
    </div>
</template>