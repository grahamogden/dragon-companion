<script setup lang="ts">
    import { Link, usePage } from '@inertiajs/vue3';

    const props = defineProps<{
        href: string,
        activeOnExact?: boolean,
    }>()

    const linkPath = new URL(props.href).pathname
    const currentPath = usePage().url;

    const isActive = (props.activeOnExact && currentPath === linkPath)
        || (!props.activeOnExact && currentPath.startsWith(linkPath))
</script>

<template>
    <Link
        class="hover:bg-timberwolf-50 focus:bg-timberwolf-50 hover:no-underline focus:no-underline focus:underline py-3 px-4 hover:lg:pl-8 focus:lg:pl-8 transition-all duration-300"
        :class="{ 'active': isActive, 'bg-transparent text-woodsmoke-950 dark:text-timberwolf-50 hover:text-shark-950 focus:text-shark-950': !isActive }"
        :href="props.href" @click="($event) => { $event.target?.blur() }">
    <slot></slot>
    </Link>
</template>