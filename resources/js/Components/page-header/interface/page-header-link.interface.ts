import type { RouteLocationRaw } from "vue-router";
import type { PageHeaderLinkActionEnum } from "./page-header-link.action.enum.js";

export interface PageHeaderLinkInterface {
    text: string;
    href: RouteLocationRaw;
    action: PageHeaderLinkActionEnum;
}
