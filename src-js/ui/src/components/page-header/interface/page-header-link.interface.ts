import type { RouteLocationRaw } from 'vue-router'
import type { PageHeaderLinkActionEnum } from './page-header-link.action.enum'

export interface PageHeaderLinkInterface {
    text: string
    destination: RouteLocationRaw
    action: PageHeaderLinkActionEnum
}
