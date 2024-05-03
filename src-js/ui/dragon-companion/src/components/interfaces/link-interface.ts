export enum LinkInterfaceTypeEnum {
    ROUTER = 'router',
    BUTTON = 'button',
}

export interface LinkInterface {
    label: string
    type: LinkInterfaceTypeEnum
    destination?: object
    function?: {
        func: Function
        args: any[]
    }
}
