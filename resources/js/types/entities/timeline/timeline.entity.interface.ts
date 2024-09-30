import type { EntityInterface } from "../entity.interface.ts";

export interface NewTimelineEntityInterface {
    name: string;
    description: string;
    parent_id: number | null;
    parent?: TimelineEntityInterface;
    children?: TimelineEntityInterface[] | null;
}

export interface TimelineEntityInterface
    extends EntityInterface,
        NewTimelineEntityInterface {}
