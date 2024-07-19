<script setup lang="ts">
    import { ref } from 'vue';
    import type { NotificationInterface } from '../../stores/notifications';
    import { useNotificationStore } from '../../stores/notifications/notification-store';
    import BaseBanner from './BaseBanner.vue';

    const notificationStore = useNotificationStore()

    const isVisible = ref<boolean>(true)
    const props = defineProps<{
        notification: NotificationInterface,
        index: string,
    }>()
</script>
<template>
    <base-banner :index="props.index" colour-classes="bg-fern-300 dark:bg-fern-700" icon-class="fa-check-circle-o"
        dismiss-hover-background-colour-class="hover:bg-fern-500">{{
        props.notification.text }}</base-banner>
</template>

<style>
    .fade-leave-from {
        opacity: 1;
    }

    .fade-leave-active {
        transition: all 0.2s linear;
    }

    .fade-leave-to {
        opacity: 0;
    }
</style>