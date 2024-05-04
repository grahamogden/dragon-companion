import type { RouteLocationRaw } from 'vue-router'

export enum DropDownItemTypeEnum {
    ROUTER = 'router',
    BUTTON = 'button',
}

export interface DropDownItemInterface {
    label: string
    type: DropDownItemTypeEnum
}

export interface DropDownItemLinkInterface {
    label: string
    type: DropDownItemTypeEnum
    destination: RouteLocationRaw
}

export class DropDownItemRouter implements DropDownItemLinkInterface {
    public type: DropDownItemTypeEnum = DropDownItemTypeEnum.ROUTER

    constructor(
        public label: string,
        public destination: RouteLocationRaw,
    ) {}
}

export interface DropDownItemButtonInterface {
    label: string
    type: DropDownItemTypeEnum
    onClickFunc: {
        func: Function
        args: any[]
    }
}

export interface DropDownItemButtonFunctionInterface {
    func: Function
    args: any[]
}

export class DropDownItemButton implements DropDownItemButtonInterface {
    public type: DropDownItemTypeEnum = DropDownItemTypeEnum.BUTTON

    constructor(
        public label: string,
        public onClickFunc: DropDownItemButtonFunctionInterface,
    ) {}
}
