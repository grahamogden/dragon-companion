import type { TimelineEntityInterface } from './TimelineEntityInterface'

export class TimelineEntity implements TimelineEntityInterface {
    id: number | null
    title: string
    body: string
    parent_id: number | null

    constructor(
        id: number | null = null,
        title: string = '',
        body: string = '',
        parent_id: number | null = null,
    ) {
        this.id = id
        this.title = title
        this.body = body
        this.parent_id = parent_id
    }
}
