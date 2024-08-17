import type { NewSpeciesEntityInterface } from '../species/SpeciesEntityInterface.js'
import type { CharacterEntityInterface } from './CharacterEntityInterface.js'

export class CharacterEntity implements CharacterEntityInterface {
    id?: number
    name: string
    age?: number
    max_hit_points?: number
    armour_class?: number
    dexterity_modifier?: number
    appearance?: string
    notes?: string
    species_id?: number
    species?: NewSpeciesEntityInterface

    constructor(
        id?: number,
        name: string = '',
        age?: number,
        maxHitPoints?: number,
        armourClass?: number,
        dexterityModifier?: number,
        appearance?: string,
        notes?: string,
        speciesId?: number,
        species?: NewSpeciesEntityInterface,
    ) {
        this.id = id
        this.name = name
        this.age = age
        this.max_hit_points = maxHitPoints
        this.armour_class = armourClass
        this.dexterity_modifier = dexterityModifier
        this.appearance = appearance
        this.notes = notes
        this.species_id = speciesId
        this.species = species
    }
}
