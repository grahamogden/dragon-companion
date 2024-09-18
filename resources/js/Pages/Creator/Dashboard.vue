<script setup lang="ts">
    import { Head } from '@inertiajs/vue3';
    import PageHeader from '../../Components/page-header/PageHeader.vue';
</script>

<template>

    <Head title="Dashboard" />

    <PageHeader class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</PageHeader>

    <div class="">You're logged in, {{ $page.props.auth.user.username
        }}!</div>
</template>
