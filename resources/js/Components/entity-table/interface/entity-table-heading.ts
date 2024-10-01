import type { EntityTableHeadingInterface } from "./entity-table-heading.interface.js";

export default class EntityTableHeading implements EntityTableHeadingInterface {
    public readonly title: string;
    public readonly isShowLink: boolean;

    constructor(title: string, isShowLink: boolean = false) {
        this.title = title;
        this.isShowLink = isShowLink;
    }
}
