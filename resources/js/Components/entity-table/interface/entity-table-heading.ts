import type EntityTableHeadingInterface from "./entity-table-heading.interface.js";

export default class EntityTableHeading implements EntityTableHeadingInterface {
    public readonly title: string;
    public readonly isLink: boolean;

    constructor(title: string, isLink: boolean = false) {
        this.title = title;
        this.isLink = isLink;
    }
}
