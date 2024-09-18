import type { RouteLocationRaw } from "vue-router";
import type { PageHeaderLinkInterface } from "./page-header-link.interface.js";
import type { PageHeaderLinkActionEnum } from "./page-header-link.action.enum.js";

export class PageHeaderLink implements PageHeaderLinkInterface {
    constructor(
        public readonly text: string,
        public readonly href: RouteLocationRaw,
        public readonly action: PageHeaderLinkActionEnum
    ) {}
}
