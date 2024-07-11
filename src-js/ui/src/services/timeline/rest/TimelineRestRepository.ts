import RestClientService from '../../repository/rest/RestClientService'
import type { NewTimelineEntityInterface } from '../TimelineEntityInterface'
import { type TimelineEntityInterface } from '../TimelineEntityInterface'
import type TimelineRepositoryInterface from '../TimelineRepositoryInterface'

export default class TimelineRestRepository implements TimelineRepositoryInterface {
    private restClient: RestClientService
    private readonly route: string = 'api/v1/campaigns/{campaignId}/timelines'

    public constructor(restClient: RestClientService) {
        this.restClient = restClient
    }

    public async findByIdAndCampaignId(
        campaignId: number,
        id: number,
    ): Promise<TimelineEntityInterface | null> {
        const res = await this.restClient.get(this.getRoute(campaignId) + '/' + id)
        let timelineResponse: TimelineEntityInterface = await res.json()
        return timelineResponse
    }

    public async findAll(campaignId: number): Promise<TimelineEntityInterface[]> {
        const res = await this.restClient.get(this.getRoute(campaignId))
        return await res.json()
    }

    public async add(campaignId: number, timeline: NewTimelineEntityInterface): Promise<number> {
        const res = await this.restClient.post(this.getRoute(campaignId), timeline)
        if (res.ok) {
            const timelineResponse = await res.json()
            return timelineResponse.id
        }
        throw new Error()
    }

    public async update(campaignId: number, timeline: TimelineEntityInterface): Promise<void> {
        const res = await this.restClient.put(
            this.getRoute(campaignId) + '/' + timeline.id,
            timeline,
        )
        if (res.ok) {
            return
        }
        throw new Error()
    }

    public async delete(campaignId: number, timelineId: number): Promise<void> {
        const res = await this.restClient.delete(this.getRoute(campaignId) + '/' + timelineId)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    private getRoute(campaignId: number): string {
        return this.route.replace('{campaignId}', campaignId.toString())
    }
}
