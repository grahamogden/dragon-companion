import type RepositoryInterface from '../repository/RepositoryInterface.js'
import { type ItemEntityInterface, type NewItemEntityInterface } from './ItemEntityInterface.js'

export default interface ItemRepositoryInterface extends RepositoryInterface {
    findByIdAndCampaignId(id: number, campaignId: number): Promise<ItemEntityInterface | null>
    findAll(campaignId: number): Promise<ItemEntityInterface[]>
    add(campaignId: number, item: NewItemEntityInterface): Promise<number>
    update(campaignId: number, item: ItemEntityInterface): Promise<void>
    delete(campaignId: number, itemId: number): Promise<void>
}
