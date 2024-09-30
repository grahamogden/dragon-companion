import { TimelineEntityInterface } from "./timeline.entity.interface";

export class TimelineEntity implements TimelineEntityInterface {
    id?: number;
    title: string;
    body: string;
    parent_id: number | null;
    child_timelines?: TimelineEntity[] | null;

    constructor(
        id?: number,
        title: string = "",
        body: string = "",
        parent_id: number | null = null,
        child_timelines?: TimelineEntity[] | null
    ) {
        this.id = id;
        this.title = title;
        this.body = body;
        this.parent_id = parent_id;
        this.child_timelines = child_timelines;
    }
}
