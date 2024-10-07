<script setup lang="ts">
  import { useNotificationStore } from '../../stores/notifications/notification-store'
  import SuccessBanner from './SuccessNotification.vue'
  import WarningBanner from './WarningNotification.vue'
  import ErrorBanner from './ErrorNotification.vue'
  import { usePage } from '@inertiajs/vue3';
  import { NotificationInterface, NotificationTypeEnum } from '../../types/inertia/page/props/notification'
  import { watch } from 'vue';
  import { InertiaPagePropsInterface } from '../../types/inertia/page/props';
  import Notification from './Notification.vue';

  const flashNotifications = usePage<InertiaPagePropsInterface>().props?.flash?.notifications ?? [];

  watch(() => usePage<InertiaPagePropsInterface>().props?.flash?.notifications ?? [], (notifications: NotificationInterface[]) => {
    console.debug('Updating notifications')
    // flashMessages.value = notifications
    notifications.forEach((notification) => {
      // switch (notification.type) {
      //   case NotificationTypeEnum.success:
      //     notificationStore.addSuccess(notification.message)
      // }
      notificationStore.addNotification(notification)
    });
  })

  const notificationStore = useNotificationStore()

</script>
<template>
  <!-- <div v-for="(notification, index) in notificationStore.notifications"> -->
  <div v-for="(notification, index) in notificationStore.notifications">
    <Notification :index="index" :notification="notification"></Notification>
    <!-- <success-banner v-if="notification.type === NotificationTypeEnum.success" :notification="notification"
      :index="index"></success-banner>
    <warning-banner v-else-if="notification.type === NotificationTypeEnum.warning" :notification="notification"
      :index="index"></warning-banner>
    <error-banner v-else-if="notification.type === NotificationTypeEnum.error" :notification="notification"
      :index="index"></error-banner> -->
  </div>
</template>