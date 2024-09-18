<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    const props = defineProps<{
        href: string
    }>()
</script>

<template>
    <Link
        class="hover:no-underline focus:no-underline focus:underline py-3 px-4 hover:lg:pl-8 focus:lg:pl-8 bg-transparent hover:bg-timberwolf-50 focus:bg-timberwolf-50 text-timberwolf-50 hover:text-shark-950 focus:text-shark-950 transition-all duration-300"
        :href="props.href">
    <slot></slot>
    </Link>
</template>