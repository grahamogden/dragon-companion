import type { EntityInterface } from '../entity/EntityInterface.js'
import type { NewSpeciesEntityInterface } from '../species/SpeciesEntityInterface.js'

export interface NewCharacterEntityInterface {
    name: string
    age?: number
    max_hit_points?: number
    armour_class?: number
    dexterity_modifier?: number
    appearance?: string
    notes?: string
    species_id?: number
    species?: NewSpeciesEntityInterface
}

export interface CharacterEntityInterface extends EntityInterface, NewCharacterEntityInterface {}
