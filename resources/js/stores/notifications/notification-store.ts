import { defineStore } from "pinia";
import type { NotificationInterface } from "./notification.interface.ts";
import { v4 as uuidv4 } from "uuid";
import { NotificationTypeEnum } from "../../types/inertia/page/props/notification/notification-type.enum.ts";

interface NotificationStoreInterface {
    notifications: Record<string, NotificationInterface>;
}

export const useNotificationStore = defineStore("notification", {
    state: (): NotificationStoreInterface => ({
        notifications: {},
    }),
    getters: {
        // successNotifications: (state) => {
        //     return state.notifications.filter((notification: NotificationInterface) => {
        //         return notification.type === NotificationTypeEnum.success
        //     })
        // },
        // warningNotifications: (state) => {
        //     return state.notifications.filter((notification: NotificationInterface) => {
        //         return notification.type === NotificationTypeEnum.warning
        //     })
        // },
        // errorNotifications: (state) => {
        //     return state.notifications.filter((notification: NotificationInterface) => {
        //         return notification.type === NotificationTypeEnum.error
        //     })
        // },
    },
    actions: {
        addNotification(notification: NotificationInterface) {
            this.notifications[uuidv4()] = notification;
        },
        addError(message: string) {
            this.addNotification({
                message: message,
                type: NotificationTypeEnum.error,
            });
        },
        addWarning(message: string) {
            this.addNotification({
                message: message,
                type: NotificationTypeEnum.warning,
            });
        },
        addSuccess(message: string) {
            this.addNotification({
                message: message,
                type: NotificationTypeEnum.success,
            });
        },
        cleanUp() {
            this.$reset();
        },
        removeNotification(key: string) {
            delete this.notifications[key];
        },
        removeAllNotifications() {
            this.$reset();
        },
    },
});
