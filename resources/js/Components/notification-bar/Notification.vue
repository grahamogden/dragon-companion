<script setup lang="ts">
    import { NotificationInterface, useNotificationStore } from '../../stores/notifications';
    import { NotificationTypeEnum } from '../../types/inertia/page/props/notification';

    const emit = defineEmits(['dismiss'])

    const props = defineProps<{
        index: string,
        notification: NotificationInterface,
    }>()

    // const dismiss = () => {
    //     console.debug('Dismiss ' + props.notification.id);
    //     delete usePage().props.flash[0]
    // }

    const notificationStore = useNotificationStore()

    let colourClasses = ''
    let iconClass = ''
    let dismissHoverBackgroundColourClass = ''

    switch (props.notification.type) {
        case NotificationTypeEnum.success:
            colourClasses = "bg-fern-300 dark:bg-fern-700"
            iconClass = "check-circle"
            dismissHoverBackgroundColourClass = "hover:bg-fern-500"
            break;
        case NotificationTypeEnum.error:
            colourClasses = "bg-alizarin-crimson-300 dark:bg-alizarin-crimson-700"
            iconClass = "exclamation-circle"
            dismissHoverBackgroundColourClass = "hover:bg-alizarin-crimson-500"
            break;
        case NotificationTypeEnum.warning:
            colourClasses = "bg-sorbus-300 dark:bg-sorbus-700"
            iconClass = "exclamation-triangle"
            dismissHoverBackgroundColourClass = "hover:bg-sorbus-500"
            break;
        case NotificationTypeEnum.info:
            colourClasses = "bg-biscay-300 dark:bg-biscay-600"
            iconClass = "circle-info"
            dismissHoverBackgroundColourClass = "hover:bg-biscay-400"
            break;
    }
</script>
<template>
    <Transition>
        <div class="flex flex-row justify-between gap-3 mb-4 dark:text-timberwolf-50 rounded-xl duration-theme-change"
            :class="colourClasses">
            <div class="flex flex-col justify-center pl-3 py-1">
                <font-awesome-icon :icon="['fa', iconClass]" fixed-width class="text-xl"></font-awesome-icon>
            </div>
            <div class="grow py-3">
                {{ notification.message }}
            </div>
            <div class="flex flex-col justify-center pr-1">
                <!-- <button class="px-3 py-2 rounded-lg text-center" :class="dismissHoverBackgroundColourClass"
                    @click.prevent="dismiss"> -->
                <button class="px-3 py-2 rounded-lg text-center" :class="dismissHoverBackgroundColourClass"
                    @click="notificationStore.removeNotification(props.index)">

                    <font-awesome-icon :icon="['fa', 'xmark']" fixed-width></font-awesome-icon>
                </button>
            </div>
        </div>
    </Transition>
</template>