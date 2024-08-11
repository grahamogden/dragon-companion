import type { RouteLocationRaw } from 'vue-router'
import type { PageHeaderLinkInterface } from './page-header-link.interface'
import type { PageHeaderLinkActionEnum } from './page-header-link.action.enum'

export class PageHeaderLink implements PageHeaderLinkInterface {
    constructor(
        public readonly text: string,
        public readonly destination: RouteLocationRaw,
        public readonly action: PageHeaderLinkActionEnum,
    ) {}
}
