import type EntityTableLinkInterface from './entity-table-link.interface'

export default class EntityTableLink implements EntityTableLinkInterface {
    public readonly routerToName: string
    public readonly idName: string

    constructor(routerToName: string, idName: string) {
        this.routerToName = routerToName
        this.idName = idName
    }
}
