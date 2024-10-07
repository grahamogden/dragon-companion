import { PageProps } from "../../..";
import { NotificationInterface } from "./notification";

export interface InertiaPagePropsInterface extends PageProps {
    flash?: {
        notifications?: NotificationInterface[];
    };
}
