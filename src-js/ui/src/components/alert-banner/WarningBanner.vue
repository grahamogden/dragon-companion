<script setup lang="ts">
    import BaseBanner from './BaseBanner.vue';
    import { type NotificationInterface } from '../../stores/notifications';

    const props = defineProps<{
        notification: NotificationInterface,
        index: string,
    }>()
</script>

<template>
    <base-banner :index="index" colour-classes="bg-sorbus-300 dark:bg-sorbus-700" icon-class="exclamation-triangle"
        dismiss-hover-background-colour-class="hover:bg-sorbus-500">{{ notification.text }}</base-banner>
</template>