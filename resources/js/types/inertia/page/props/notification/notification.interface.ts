import { NotificationTypeEnum } from "./notification-type.enum";

export interface NotificationInterface {
    // id: string;
    type: NotificationTypeEnum;
    title: string;
    message: string;
}
