import { defineStore } from 'pinia'
import { useLocalStorage, type RemovableRef } from '@vueuse/core'
import {
    type TimelineEntityInterface,
    type NewTimelineEntityInterface,
} from '../services/timeline/TimelineEntityInterface'
import TimelineRestRepository from '@/services/timeline/rest/TimelineRestRepository'
import type TimelineRepositoryInterface from '../services/timeline/TimelineRepositoryInterface'
import { TimelineEntity } from '../services/timeline'

export const useTimelineStore = defineStore('timeline', {
    actions: {
        _getTimelineRespository(): TimelineRepositoryInterface {
            return new TimelineRestRepository(this.restClient)
        },
        async findTimelines(
            campaignId: number,
            includeChildren?: boolean,
            level?: number,
        ): Promise<TimelineEntityInterface[]> {
            let timeline: TimelineEntity[] = []

            const timelineResponse = await this._getTimelineRespository().findAll(
                campaignId,
                includeChildren,
                level,
            )
            timelineResponse?.forEach((timelineResponse: TimelineEntity) => {
                timeline.push(timelineResponse)
            })
            return timeline
        },
        async findOneTimeline(
            campaignId: number,
            id: number,
            includeChildren: boolean = false,
        ): Promise<TimelineEntityInterface | null> {
            return await this._getTimelineRespository().findByIdAndCampaignId(
                campaignId,
                id,
                includeChildren,
            )
        },
        async addTimeline(campaignId: number, timeline: NewTimelineEntityInterface): Promise<void> {
            const timelineId = await this._getTimelineRespository().add(campaignId, timeline)
            // const newTimeline: TimelineEntityInterface = new TimelineEntity(
            //     timelineId,
            //     timeline.title,
            //     timeline.body,
            //     timeline.parent_id,
            // )
        },
        async updateTimeline(campaignId: number, timeline: TimelineEntityInterface): Promise<void> {
            await this._getTimelineRespository().update(campaignId, timeline)
        },
        async deleteTimeline(campaignId: number, timelineId: number): Promise<void> {
            await this._getTimelineRespository().delete(campaignId, timelineId)
        },
    },
})
