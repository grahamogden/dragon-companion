import type { EntityInterface } from '../entity/EntityInterface'

export interface NewSpeciesEntityInterface {
    name: string
}

export interface SpeciesEntityInterface extends EntityInterface, NewSpeciesEntityInterface {}
