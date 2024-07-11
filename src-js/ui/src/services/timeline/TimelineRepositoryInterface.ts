import type RepositoryInterface from '../repository/RepositoryInterface'
import {
    type TimelineEntityInterface,
    type NewTimelineEntityInterface,
} from './TimelineEntityInterface'

export default interface TimelineRepositoryInterface extends RepositoryInterface {
    findByIdAndCampaignId(id: number, campaignId: number): Promise<TimelineEntityInterface | null>
    findAll(campaignId: number): Promise<TimelineEntityInterface[]>
    add(campaignId: number, timeline: NewTimelineEntityInterface): Promise<number>
    update(campaignId: number, timeline: TimelineEntityInterface): Promise<void>
    delete(campaignId: number, timelineId: number): Promise<void>
}
