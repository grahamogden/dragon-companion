import { defineStore } from 'pinia'
import type { NotificationInterface } from './notification.interface'
import { v4 as uuidv4 } from 'uuid'
import { NotificationEnum } from './notification.enum'

interface NotificationStoreInterface {
    notifications: Record<string, NotificationInterface>
}

export const useNotificationStore = defineStore('notification', {
    state: (): NotificationStoreInterface => ({
        notifications: {},
    }),
    getters: {
        // successNotifications: (state) => {
        //     return state.notifications.filter((notification: NotificationInterface) => {
        //         return notification.type === NotificationEnum.success
        //     })
        // },
        // warningNotifications: (state) => {
        //     return state.notifications.filter((notification: NotificationInterface) => {
        //         return notification.type === NotificationEnum.warning
        //     })
        // },
        // errorNotifications: (state) => {
        //     return state.notifications.filter((notification: NotificationInterface) => {
        //         return notification.type === NotificationEnum.error
        //     })
        // },
    },
    actions: {
        addNotification(notification: NotificationInterface) {
            this.notifications[uuidv4()] = notification
        },
        addError(text: string) {
            this.addNotification({
                text: text,
                type: NotificationEnum.error,
            })
        },
        addWarning(text: string) {
            this.addNotification({
                text: text,
                type: NotificationEnum.warning,
            })
        },
        addSuccess(text: string) {
            this.addNotification({
                text: text,
                type: NotificationEnum.success,
            })
        },
        cleanUp() {
            this.$reset()
        },
        removeNotification(key: string) {
            delete this.notifications[key]
        },
        removeAllNotifications() {
            this.$reset()
        },
    },
})
