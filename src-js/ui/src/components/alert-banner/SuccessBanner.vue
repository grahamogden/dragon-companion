<script setup lang="ts">
    import BaseBanner from './BaseBanner.vue';
    import { type NotificationInterface } from '../../stores/notifications';

    const props = defineProps<{
        notification: NotificationInterface,
        index: string,
    }>()
</script>

<template>
    <base-banner :index="index" colour-classes="bg-fern-300 dark:bg-fern-700" icon-class="check-circle"
        dismiss-hover-background-colour-class="hover:bg-fern-500">{{
        notification.text }}</base-banner>
</template>