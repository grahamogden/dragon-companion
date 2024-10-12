import type { EntityTableHeadingInterface } from "./entity-table-heading.interface.js";

export default class EntityTableHeading implements EntityTableHeadingInterface {
    public readonly heading: string;
    public readonly field: string;
    public readonly isLink?: boolean;

    constructor(heading: string, field: string, link: boolean = false) {
        this.heading = heading;
        this.field = field;
        this.isLink = link;
    }
}
