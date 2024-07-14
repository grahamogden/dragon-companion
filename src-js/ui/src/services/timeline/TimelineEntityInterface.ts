import type { EntityInterface } from '../entity/EntityInterface'

export interface NewTimelineEntityInterface {
    title: string
    body: string
    parent_id: number | null
    child_timelines?: TimelineEntityInterface[] | null
}

export interface TimelineEntityInterface extends EntityInterface, NewTimelineEntityInterface {}
