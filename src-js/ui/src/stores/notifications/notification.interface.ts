import type { NotificationEnum } from './notification.enum'

export interface NotificationInterface {
    type: NotificationEnum
    text: string
}
