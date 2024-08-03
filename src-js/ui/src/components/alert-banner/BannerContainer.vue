<script setup lang="ts">
  import { useNotificationStore } from '../../stores/notifications/notification-store'
  import { NotificationEnum } from '../../stores/notifications'
  import SuccessBanner from './SuccessBanner.vue'
  import WarningBanner from './WarningBanner.vue'
  import ErrorBanner from './ErrorBanner.vue'


  const notificationStore = useNotificationStore()

</script>
<template>
  <div v-for="(notification, index) in notificationStore.notifications">
    <success-banner v-if="notification.type === NotificationEnum.success" :notification="notification"
      :index="index"></success-banner>
    <warning-banner v-else-if="notification.type === NotificationEnum.warning" :notification="notification"
      :index="index"></warning-banner>
    <error-banner v-else-if="notification.type === NotificationEnum.error" :notification="notification"
      :index="index"></error-banner>
  </div>
</template>