import type { SpeciesEntityInterface } from "./species.entity.interface.ts";

export class SpeciesEntity implements SpeciesEntityInterface {
    id?: number;
    name: string;

    constructor(id?: number, name: string = "") {
        this.id = id;
        this.name = name;
    }
}
