import type RepositoryInterface from '../repository/RepositoryInterface'
import {
    type CampaignEntityInterface,
    type NewCampaignEntityInterface,
} from './CampaignEntityInterface'

export default interface CampaignRepositoryInterface extends RepositoryInterface {
    findById(id: number): Promise<CampaignEntityInterface | null>
    findAllByUser(): Promise<CampaignEntityInterface[] | null>
    add(campaign: NewCampaignEntityInterface): Promise<number>
    update(campaign: CampaignEntityInterface): Promise<void>
    delete(campaignId: number): Promise<void>
}
