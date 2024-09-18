import type { NotificationEnum } from './notification.enum.ts'

export interface NotificationInterface {
    type: NotificationEnum
    text: string
}
