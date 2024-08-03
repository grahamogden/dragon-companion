<script setup lang="ts">
    import BaseBanner from './BaseBanner.vue';
    import type { NotificationInterface } from '../../stores/notifications';

    const props = defineProps<{
        notification: NotificationInterface,
        index: string,
    }>()
</script>

<template>
    <base-banner :index="index" colour-classes="bg-alizarin-crimson-300 dark:bg-alizarin-crimson-700"
        icon-class="fa-exclamation-circle" dismiss-hover-background-colour-class="hover:bg-alizarin-crimson-500">
        {{ props.notification.text }}
    </base-banner>
</template>