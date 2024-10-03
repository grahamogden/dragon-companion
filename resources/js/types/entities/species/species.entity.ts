import type { SpeciesEntityInterface } from "./species.entity.interface.ts";

export class SpeciesEntity implements SpeciesEntityInterface {
    id?: number;
    name: string;
    description?: string;

    constructor(name: string, id?: number, description?: string) {
        this.id = id;
        this.name = name;
        this.description = description;
    }
}
