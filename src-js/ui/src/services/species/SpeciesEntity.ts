import type { SpeciesEntityInterface } from './SpeciesEntityInterface'

export class SpeciesEntity implements SpeciesEntityInterface {
    id?: number
    name: string

    constructor(id?: number, name: string = '') {
        this.id = id
        this.name = name
    }
}
