import type { ItemEntityInterface } from "./item.entity.interface.ts";

export class ItemEntity implements ItemEntityInterface {
    id?: number;
    name: string;
    description: string;

    constructor(id?: number, name: string = "", description: string = "") {
        this.id = id;
        this.name = name;
        this.description = description;
    }
}
