import type {
    EntityInterface,
    IndexEntityInterface,
} from "../entity.interface.ts";

export interface NewSpeciesEntityInterface {
    name: string;
    description?: string;
}

export interface SpeciesEntityInterface
    extends EntityInterface,
        NewSpeciesEntityInterface {}

export interface SpeciesIndexEntityInterface
    extends SpeciesEntityInterface,
        IndexEntityInterface {}
