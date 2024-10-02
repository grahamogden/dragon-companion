import type {
    EntityInterface,
    IndexEntityInterface,
} from "../entity.interface.ts";
import type { SpeciesEntityInterface } from "../species";

export interface NewCharacterEntityInterface {
    name: string;
    age?: number | null;
    max_hit_points?: number | null;
    armour_class?: number | null;
    dexterity_modifier?: number | null;
    appearance?: string | null;
    notes?: string | null;
    species_id?: number | null;
    species?: SpeciesEntityInterface | null;
}

export interface CharacterEntityInterface
    extends EntityInterface,
        NewCharacterEntityInterface {}

export interface CharacterIndexEntityInterface
    extends CharacterEntityInterface,
        IndexEntityInterface {}
