import type { SpeciesEntityInterface } from '.'

export class SpeciesEntity implements SpeciesEntityInterface {
    id: number | null
    name: string

    constructor(id: number | null = null, name: string = '') {
        this.id = id
        this.name = name
    }
}
