import type { SpeciesEntityInterface } from "../species";
import type { CharacterEntityInterface } from "./character.entity.interface.ts";

export class CharacterEntity implements CharacterEntityInterface {
    name: string;
    id?: number;
    age?: number;
    max_hit_points?: number;
    armour_class?: number;
    dexterity_modifier?: number;
    appearance?: string;
    notes?: string;
    species_id?: number;
    species?: SpeciesEntityInterface;

    constructor(
        name: string = "",
        id?: number,
        age?: number,
        maxHitPoints?: number,
        armourClass?: number,
        dexterityModifier?: number,
        appearance?: string,
        notes?: string,
        speciesId?: number,
        species?: SpeciesEntityInterface
    ) {
        this.id = id;
        this.name = name;
        this.age = age;
        this.max_hit_points = maxHitPoints;
        this.armour_class = armourClass;
        this.dexterity_modifier = dexterityModifier;
        this.appearance = appearance;
        this.notes = notes;
        this.species_id = speciesId;
        this.species = species;
    }
}
