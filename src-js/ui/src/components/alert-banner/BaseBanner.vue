<script setup lang="ts">
    import { useNotificationStore } from '../../stores/notifications/notification-store';

    const notificationStore = useNotificationStore()

    const props = defineProps<{
        index: string,
        colourClasses: string,
        iconClass: string,
        dismissHoverBackgroundColourClass: string
    }>()
</script>
<template>
    <Transition>
        <div class="flex flex-row justify-between gap-3 mb-4 dark:text-timberwolf-50 rounded-xl duration-500"
            :class="props.colourClasses">
            <div class="flex flex-col justify-center pl-3 py-1">
                <i class="fa text-2xl" :class="props.iconClass" aria-hidden="true"></i>
            </div>
            <div class="grow py-3">
                <slot></slot>
            </div>
            <div class="flex flex-col justify-center pr-1">
                <button class="px-3 py-2 rounded-lg text-center" :class="props.dismissHoverBackgroundColourClass"
                    @click="notificationStore.removeNotification(props.index)">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </Transition>
</template>