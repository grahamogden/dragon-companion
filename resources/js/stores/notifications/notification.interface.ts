import { NotificationTypeEnum } from "../../types/inertia/page/props/notification/notification-type.enum.ts";

export interface NotificationInterface {
    type: NotificationTypeEnum;
    message: string;
}
