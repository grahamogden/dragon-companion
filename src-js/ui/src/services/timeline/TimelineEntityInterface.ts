import type { EntityInterface } from '../entity/EntityInterface'

export interface TimelineEntityInterface extends EntityInterface {
    title: string
    body: string
    parent_id: number | null
}

export interface NewTimelineEntityInterface {
    title: string
    body: string
    parent_id: number | null
}
