import type { EntityInterface } from '../entity/EntityInterface'

export interface CampaignEntityInterface extends EntityInterface {
    name: string
    synopsis: string
}

export interface NewCampaignEntityInterface {
    name: string
    synopsis: string
}
