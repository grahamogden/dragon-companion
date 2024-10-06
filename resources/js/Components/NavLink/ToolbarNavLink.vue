<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    const props = defineProps<{
        href: string
    }>()

    const currentPage = new URL(props.href).pathname
</script>

<template>
    <Link
        class="hover:no-underline focus:no-underline focus:underline py-3 px-4 hover:lg:pl-8 focus:lg:pl-8 bg-transparent hover:bg-timberwolf-50 focus:bg-timberwolf-50 text-woodsmoke-950 dark:text-timberwolf-50 hover:text-shark-950 focus:text-shark-950 transition-all duration-300"
        :class="{ 'active': $page.url.startsWith(currentPage) }" :href="props.href"
        @click="($event) => { $event.target?.blur() }">
    <slot></slot>
    </Link>
</template>